<?php

namespace PbbgIo\TitanFramework\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use PbbgIo\TitanFramework\Extensions;

class ExtensionController extends Controller
{

    private $localExtensions;
    private $publicExtensions;

    public function index(): View
    {
        $availableExtensions = $this->loadPublicExtensions()->all();

        if (request()->query('page', 0) === 0) {
            $offset = 0;
        } else {
            $offset = request()->query('page', 1) * 9;
        }

        $availableExtensions = new LengthAwarePaginator(array_slice($availableExtensions, $offset, 9),
            count($availableExtensions), 9);

        $availableExtensions->withPath(route('admin.extensions.index'));

        $localExtensions = $this->loadLocalExtensions();

        return view('titan::admin.extensions.index', compact('availableExtensions', 'localExtensions'));
    }

    public function showMarketplacePage($slug): View
    {
        $ext = Extensions::where('slug', $slug)->first() ?? new \stdClass();

        $ext->json = $this->getExtensionFromJSON($slug);

        $extensionName = $ext->json['name'];

        return view('titan::admin.extensions.manage', compact('extensionName', 'ext'));
    }

    public function manage($slug): View
    {
        $ext = Extensions::where('slug', $slug)->first() ?? new \stdClass();

        $ext->json = $this->getExtensionFromJSON($slug);

        $extensionName = $ext->json['name'];

        if (!$ext->json) {
            abort(404, 'No extension was found');
        }


        $call = $this->callExtensionMethod('AdminController', 'index', $ext);

        if($call !== false)
            return $call;

        return view('titan::admin.extensions.manage', compact('extensionName', 'ext'));
    }

    private function callExtensionMethod($className, $method, $ext)
    {
        $class = $ext['namespace'] . '\\' . $className;

        $extension = new $class;

        if (method_exists($extension, $method)) {
            return $extension->$method();
        } else {
            var_dump($extension);
        }

        return false;
    }

    private function loadLocalExtensions(): Collection
    {
        if ($this->localExtensions) {
            return $this->localExtensions;
        }

        $localExtensionFiles = glob(base_path('/extensions/*/*/composer.json'));
        $localExtensions = [];

        foreach ($localExtensionFiles as $file) {
            $composer = json_decode(file_get_contents($file));

            if (!$composer) {
                continue;
            }

            $nameEx = explode('/', $composer->name);
            $author = $nameEx[0];
            $packageName = $nameEx[1];

            $localExtensions[] = [
                'name' => $composer->extra->titan->name,
                'description' => $composer->description,
                'version' => '1.0.0',
                'authors' => $composer->authors,
                'slug' => \Str::kebab(str_replace(['\\', 'Extensions'], [' ', ''], $composer->extra->titan->namespace)),
                'rating' => '4.0',
                'ratings' => 20,
                'installs' => 3237,
                'local' => true,
                'namespace' => $composer->extra->titan->namespace,
            ];

        }

        $this->localExtensions = collect($localExtensions);

        return $this->localExtensions;
    }

    private function loadPublicExtensions(): Collection
    {

        if ($this->publicExtensions) {
            return $this->publicExtensions;
        }

        $availableExtensions = json_decode(\Storage::disk('local')->get('extensions.json'), true);

        $this->publicExtensions = collect($availableExtensions['extensions']);

        return $this->publicExtensions;
    }

    private function getExtensionFromJSON($slug): array
    {
        $found = $this->loadLocalExtensions()->firstWhere('slug', $slug);

        // Try checking locally
        if (!$found) {
            $extensions = $this->loadPublicExtensions();
            $found = $extensions->firstWhere('slug', $slug);
        }


        return $found;
    }

    public function install($slug): RedirectResponse
    {
        if (Extensions::whereSlug($slug)->exists()) {
            flash("That extension is already installed")->error();
            return redirect()->back();
        }

        $eJson = $this->getExtensionFromJSON($slug);

        $call = $this->callExtensionMethod('InstallController', 'install', $eJson);

        $extension = new Extensions();
        $extension->namespace = $eJson['namespace'];
        $extension->slug = $eJson['slug'];
        $extension->save();

        flash("{$eJson['name']} has been installed")->success();

        return redirect()->route('admin.extensions.show', $extension->slug);
    }

    public function uninstall($slug)
    {
        $extension = Extensions::where('slug', $slug)->first();

        if (!$extension->exists()) {
            flash("This extension hasn't been installed yet")->error();

            return redirect()->back();
        }

        $eJson = $this->getExtensionFromJSON($slug);

        $call = $this->callExtensionMethod('InstallController', 'uninstall', $extension);

        flash("{$eJson['name']} has been uninstalled")->success();

        $extension->delete();

        return redirect()->route('admin.extensions.show', $extension->slug);

    }
}
