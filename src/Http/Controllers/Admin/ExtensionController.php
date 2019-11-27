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

        return view('titan::admin.extensions.manage', compact('extensionName', 'ext'));
    }

    private function getExtensionFromJSON($extension): object
    {
        $extensions = json_decode(\Storage::disk('local')->get('extensions.json'))->extensions;

        $extensions = collect($extensions);

        return $extensions->firstWhere('slug', $extension);
    }

    public function install()
    {

    }

    public function uninstall()
    {

    }
}
