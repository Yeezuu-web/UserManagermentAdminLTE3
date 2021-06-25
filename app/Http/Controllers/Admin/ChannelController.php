<?php

namespace App\Http\Controllers\Admin;

use App\Models\Channel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChannelController extends Controller
{
    public function index()
    {
        return view('admin.channels.index');
    }
    public function store()
    {
        return view('admin.channels.index');
    }
    public function edit(Channel $channel)
    {
        return view('admin.channels.index');
    }
    public function update(Channel $channel)
    {
        return view('admin.channels.index');
    }
    public function delete(Channel $channel)
    {
        return view('admin.channels.index');
    }
}
