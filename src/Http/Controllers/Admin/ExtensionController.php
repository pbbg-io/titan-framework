<?php

namespace PbbgIo\TitanFramework\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use PbbgIo\TitanFramework\Extensions;

class ExtensionController extends Controller
{

    public function index(): View
    {
        $availableExtensions = json_decode(\Storage::disk('local')->get('extensions.json'));

        $availableExtensions = $availableExtensions->extensions;

        return view('titan::admin.extensions.index', compact('availableExtensions'));
    }

    public function manage($slug): View
    {
        $ext = Extensions::findBySlug($slug) ?? new \stdClass();

        $extensionName = $slug;

        $ext->json = $this->getExtensionFromJSON($slug);

        if (!$ext->json) {
            abort(404, 'No extension was found');
        }

        $name = \Str::studly($ext->json->name);
        $author = \Str::studly($ext->json->author->name);
        $class = "\\Extensions\\{$author}\\{$name}\\AdminController";
        $lowerName = \Str::kebab($name);
        $lowerAuthor = \Str::kebab($author);

        $file = base_path("extensions/{$lowerAuthor}/{$lowerName}/AdminController.php");

        if(file_exists($file))
        {
            include $file;

            if(class_exists($class))
            {
                $extension = new $class;
                return $extension->index();
            }
        }

        return view('titan::admin.extensions.manage', compact('extensionName', 'ext'));
    }

    private function getExtensionFromJSON($extension): object
    {
        $extensions = json_decode(\Storage::disk('local')->get('extensions.json'))->extensions;

        $extensions = collect($extensions);

        return $extensions->firstWhere('slug', $extension);
    }

    public function install($slug)
    {
        $eJson = $this->getExtensionFromJSON($slug);
        $extension = new Extensions();
        $extension->name = $eJson->name;
        $extension->author = $eJson->author->name;
        $extension->version = $eJson->version;

        $extension->save();

        flash("{$extension->name} has been installed")->success();

        return redirect()->route('admin.extensions.manage', $extension->slug);
    }

    public function uninstall()
    {

    }
}
