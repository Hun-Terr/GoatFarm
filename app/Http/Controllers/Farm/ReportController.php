<?php

namespace App\Http\Controllers\Farm;

use App\Http\Controllers\Controller;
use App\Models\Goat;
use App\Models\Report;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $data = Report::with('goat')->orderBy('report_date')->get();
        return view('admin.report.index',compact('data'));
    }

    public function add(Request $request)
    {
        $goats = Goat::orderBy('id')->get();

        if($request->goat_link_id == 0){
            $goat_link_id = null;
        }
        else{
            $goat_link_id = $request->goat_link_id;
        }
        return view('admin.report.add',compact('goats','goat_link_id'));

    }

    public function store(Request $request)
    {
        $this->validate($request, [

        ]);

        $report = new Report();
        $report->title = $request->title;
        $report->content = $request->description;
        $report->report_date = $request->report_date;
        if($request->hasFile('image'))
        {
            $imgName = 'ReportAdd_'.time().'.'.$request->image->extension();
            $request->image->move(env("IMAGES_PATH"), $imgName);
            $report->image = $imgName;
        }
        if($request->has('goat_id')){
            $report->goat_id = $request->goat_id;
        }

        $report->save();

        return redirect()->route('report.index')
            ->with('success','Report Added to Your Diary successfully');
    }

    public function edit(Request $request,$id)
    {
        $goats = Goat::orderBy('id')->get();
        $report = Report::find($id);

        return view('admin.report.edit',compact('goats','report'));

    }

    public function edit_store(Request $request,$id)
    {
        $this->validate($request, [

        ]);

        $report = Report::find($id);
        $report->title = $request->title;
        $report->content = $request->description;
        $report->report_date = $request->report_date;
        $report->goat_id = $request->goat_id;

        if($request->hasFile('image'))
        {
            $imgName = 'ReportEdit_'.time().'.'.$request->image->extension();
            $request->image->move(env("IMAGES_PATH"), $imgName);
            $report->image = $imgName;
        }

        $report->save();

        return redirect()->route('report.index')
            ->with('success','Report Updated successfully');
    }

    public function delete($id)
    {
        Report::find($id)->delete();
        return redirect()->route('report.index')
            ->with('success','Report deleted successfully');
    }
}
