<?php

namespace App\Http\Controllers;

use App\Models\templateM;
use Illuminate\Http\Request;

class TamplateController extends Controller
{
    public function index()
    {
        $activePage = 'template';
        $templates = TemplateM::all();
        return view('admin.template.index', ['activePage' => $activePage, 'templates' => $templates]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'namatemplate' => 'required|string|max:255',
            'template' => 'nullable|file|mimes:doc,docx',
        ]);

        $template = TemplateM::findOrFail($id);
        $template->namatemplate = $request->namatemplate;

        if ($request->hasFile('template')) {
            // Get the current file name from the database
            $currentFilePath = $template->template;
            $currentFileName = basename($currentFilePath);

            // Delete the old file from the public path
            $oldFilePath = public_path($currentFilePath);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            // Store the new file in the public path with the old file name
            $file = $request->file('template');
            $file->move(public_path(), $currentFileName);

            // Update the file path in the database
            $template->template = $currentFileName;
        }

        $template->save();

        return redirect()->route('tamplate.index')->with('success', 'Template updated successfully.');
    }
}
