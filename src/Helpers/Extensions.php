<?php

namespace PbbgIo\Titan\Helpers;

use Illuminate\Support\Collection;

class Extensions
{

    private $extensions;

    private $currentExtension;

    public function __construct()
    {
        $this->extensions = $this->getCache();
    }

    public function getCache($force = false)
    {
        if($this->extensions && !$force)
        {
            return $this->extensions;
        }

        $cache = json_decode(cache('local_extensions'), true);
        $cache = collect($cache);

        $this->extensions = $cache;

        return $cache;
    }

    public function get($extension)
    {
        return $this->extensions->firstWhere('slug', $extension);
    }

    private function set($values, $slug = null)
    {
        $e = $this->extensions->firstWhere('slug', $slug ?? $this->currentExtension->slug);

        $this->extensions = $this->extensions->map(function ($item) use ($slug, $values) {
            if ($item['slug'] === $slug) {
                $item = array_merge($item, $values);
            }

            return $item;
        });

        $this->save();
    }

    public function enable($slug = null)
    {
        $this->set(['enabled' => true], $slug);
    }

    public function disable($slug = null)
    {
        $this->set(['enabled' => false], $slug);
    }

    public function enabled($slug = null) {
        return $this->get($slug)['enabled'] === true;
    }

    public function disabled($slug = null) {
        return !$this->enabled();
    }

    public function save()
    {
        cache()->put('local_extensions', json_encode($this->extensions));

        return $this;
    }


}
