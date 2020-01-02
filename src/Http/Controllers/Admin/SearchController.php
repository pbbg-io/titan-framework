<?php

namespace PbbgIo\Titan\Http\Controllers\Admin;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PbbgIo\Titan\Models\Settings;

class SearchController extends Controller
{
    private $search_term;

    public function index() {
        $this->search_term = $search_term = request()->input('search');

        $results = [];

        $results['members'] = $this->getMembers();
        $results['settings'] = $this->getSettings();

        return view('titan::admin.search.index', compact('results', 'search_term'));
    }

    private function getMembers(): Collection {

        return User::where('name', 'LIKE', '%' . $this->search_term . '%')
            ->orWhere('email', 'LIKE', '%' . $this->search_term . '%')
            ->limit(15)
            ->get();
    }

    private function getSettings(): Collection {
        return Settings::where('key', 'LIKE', '%'. $this->search_term .'%')
            ->orWhere('value', 'LIKE', '%'. $this->search_term .'%')
            ->limit(15)
            ->get();
    }
}
