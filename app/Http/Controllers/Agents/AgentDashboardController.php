<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgentDashboardController extends Controller
{
    public function index()
    {
        return view('agents.dashboard.index');
    }
}
