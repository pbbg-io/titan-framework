<?php

namespace PbbgIo\Titan\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use PbbgIo\Titan\Extensions;

class ExtensionController extends Controller
{

    private $local_extensions;
    private $remote_extensions;

    public function index(): View
    {
        $extensions = resolve('extensions')->getCache();

        $type = request()->query('type', 'all');

        $enabled = request()->query('enabled', null);

        if ($type === 'local') {
            $extensions = $this->loadExtensions('local_extensions', $enabled);
        } else {
            if ($type === 'vendor') {
                $extensions = $this->loadExtensions('remote_extensions', $enabled);
            } else {
                $extensions = $this->loadExtensions('local_extensions', $enabled);
            }
        }

        $perPage = 9;

        $offset = (request()->query('page', 1) - 1) * 1;

        $extensions = new LengthAwarePaginator(
            array_slice($extensions->toArray(), $offset, $perPage),
            $extensions->count(),
            $perPage
        );

        $extensions->withPath(route('admin.extensions.index'));

        [$currentFilter, $filters] = $this->handleFilters();

        return view('titan::admin.extensions.index', compact('extensions', 'filters', 'currentFilter'));
    }

    public function showMarketplacePage($slug): View
    {
        $extension = resolve('extensions')->getCache()->firstWhere('slug', $slug);

        if (!$extension) {
            abort(404, 'No extension was found');
        }

        return view('titan::admin.extensions.manage', compact('extension'));
    }

    public function manage($slug): View
    {

        $extension = resolve('extensions')->getCache()->firstWhere('slug', $slug);


        if (!$extension) {
            abort(404, 'No extension was found');
        }

        $call = $this->callExtensionMethod('Http\Controllers\AdminController', 'index', $extension);

        if($call !== false)
            return $call;

        return view('titan::admin.extensions.manage', compact('extension'));
    }

    private function handleFilters()
    {
        $currentFilter = function ($filter, $option) {
            $filters = [];

            foreach (request()->query() as $param => $value) {
                $filters[$param] = $value;
            }

            $filters[$filter['param']] = $option;

            return $filters;
        };

        $filters = [
            [
                // Header on the filter
                'filter_name' => 'Type',
                //Query param name
                'param' => 'type',
                // Filters to display
                'options' => [
                    'all' => 'All Modules',
                    'vendor' => '3rd Party Modules',
                    'local' => 'Your Modules',
                ],
                'default' => 'all'
            ],
            [
                'filter_name' => 'Enabled',
                'param' => 'enabled',
                'options' => [
                    'all' => 'All Modules',
                    'true' => 'Enabled',
                    'false' => 'Disabled',
                ],
                'default' => 'all'
            ],
        ];

        return [$currentFilter, $filters];
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

    private function loadExtensions(string $type, $enabled = null) {

        if (!$this->$type) {
            $cache = resolve('extensions')->getCache();
        } else {
            $cache = $this->$type;
        }

        if($enabled === "true")
            $cache = $cache->where('enabled', true);
        else if($enabled === "false")
            $cache = $cache->where('enabled', false);

        $this->$type = $cache;

        return $cache;
    }

    public function install($slug): RedirectResponse
    {
        $cache = resolve('extensions');

        $cache->enable($slug);

        $extension = $cache->getCache()->firstWhere('slug', $slug);

        $provider = "\\{$extension['namespace']}\\ServiceProvider";

        app()->register($provider);

        $this->callExtensionMethod('InstallController', 'install', $extension);

        flash("{$extension['name']} has been installed")->success();

        return redirect()->route('admin.extensions.show', $extension['slug']);
    }

    public function uninstall($slug)
    {
        $cache = resolve('extensions');

        $cache->disable($slug);

        $extension = $cache->getCache()->firstWhere('slug', $slug);

        $provider = "\\{$extension['namespace']}\\ServiceProvider";

        app()->register($provider);

        $this->callExtensionMethod('InstallController', 'uninstall', $extension);

        flash("{$extension['name']} has been uninstalled")->success();

        return redirect()->route('admin.extensions.show', $extension['slug']);

    }
}
