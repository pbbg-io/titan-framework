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

class ModuleController extends Controller
{

    private $localModules;
    private $publicModules;

    public function index(): View
    {

        $type = request()->query('type', 'all');

        $enabled = request()->query('enabled', null);

        if ($type === 'local') {
            $modules = $this->getLocalModules($enabled);
        } else {
            if ($type === 'vendor') {
                $modules = $this->getVendorModules($enabled);
            } else {
                $modules = $this->getAllModules($enabled);
            }
        }

        $modules = $modules->mapInto(Collection::class);

        $perPage = 9;

        $offset = (request()->query('page', 1) - 1) * 1;

        $availableModules = new LengthAwarePaginator(array_slice($modules->all(), $offset, $perPage),
            count($modules->all()), $perPage);

        $modules = $availableModules->withPath(route('admin.modules.index'));

        [$currentFilter, $filters] = $this->handleFilters();


        return view('titan::admin.modules.index', compact('modules', 'filters', 'currentFilter'));
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

    private function getVendorModules($enabled = null): Collection
    {
        $vendor = modules('vendor');

        if ($enabled === "true") {
            $vendor = $vendor->enabled();
        } elseif ($enabled === "false") {
            $vendor = $vendor->disabled();
        } else {
            $vendor = $vendor->all();
        }

        $vendor = $vendor->map(function ($el) {
            $el['location'] = 'vendor';

            return $el;
        });

        return $vendor->mapInto(Collection::class);
    }

    private function getLocalModules($enabled = null): Collection
    {
        $local = modules('app');

        if ($enabled === "true") {
            $local = $local->enabled();
        } elseif ($enabled === "false") {
            $local = $local->disabled();
        } else {
            $local = $local->all();
        }

        $local = $local->map(function ($el) {
            $el['local'] = true;
            $el['location'] = 'app';

            return $el;
        });

        return $local->mapInto(Collection::class);
    }

    private function getAllModules($enabled = null): Collection
    {
        $vendor = $this->getVendorModules($enabled);

        $local = $this->getLocalModules($enabled);

        return $vendor->merge($local);
    }

    public function showMarketplacePage($slug): View
    {
        $module = $this->getAllModules()->firstWhere('slug', $slug);

        return view('titan::admin.modules.manage', compact('module'));
    }

    public function manage($slug): View
    {
        $module = $this->getAllModules()
            ->firstWhere('slug', $slug)
            ->toArray();

        if (!$module) {
            abort(404, 'No module was found');
        }

        $call = $this->callModuleMethod('AdminController', 'index', $module);

        if ($call !== false && $call instanceof View) {
            return $call;
        }

        return view('titan::admin.modules.manage', compact('module'));
    }

    private function callModuleMethod($className, $method, $module)
    {
        $class = module_class($module['slug'], 'Controllers\\' .$className, $module['location']);

        if(!class_exists($class))
        {
            abort(503, "Class '{$class}' not found for module '{$module['slug']}'");
        }

        $moduleClass = new $class;

        if (method_exists($moduleClass, $method)) {
            return $moduleClass->$method();
        } else {
            abort(503, "Method '{$method}' on controller '{$className}' not found for module '{$module['slug']}'");
        }

        return false;
    }

    public function install($slug): RedirectResponse
    {
        $module = $this->getAllModules()
            ->firstWhere('slug', $slug)
            ->toArray();

        if (!$module || !isset($module['enabled'])) {
            flash("This module hasn't been installed yet")->error();

            return redirect()->back();
        }

        $call = $this->callModuleMethod('InstallController', 'install', $module);

        flash("{$module['name']} has been uninstalled")->success();

        modules($module['location'])->enable($slug);

        return redirect()->route('admin.modules.show', $module['slug']);
    }

    public function uninstall($slug)
    {
        $module = $this->getAllModules()
            ->firstWhere('slug', $slug)
            ->toArray();

        if (!$module || !isset($module['enabled'])) {
            flash("This module hasn't been installed yet")->error();

            return redirect()->back();
        }

        $call = $this->callModuleMethod('InstallController', 'uninstall', $module);

        flash("{$module['name']} has been uninstalled")->success();

        modules($module['location'])->disable($slug);

        return redirect()->route('admin.modules.show', $module['slug']);

    }
}
