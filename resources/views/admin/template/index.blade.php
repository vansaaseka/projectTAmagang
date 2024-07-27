@extends('admin.layouts.main')

@section('content')
    <div class="container mt-4">
        <h4>Template</h4>
        @if ($templates->isEmpty())
            <p>No templates available.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Template Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($templates as $template)
                        <tr>
                            <td>{{ $template->id }}</td>
                            <td>{{ $template->namatemplate }}</td>
                            <td>{{ $template->template }}</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm text-white" data-toggle="modal"
                                    data-target="#editTemplateModal{{ $template->id }}" data-id="{{ $template->id }}"
                                    data-name="{{ $template->namatemplate }}">
                                    Edit
                                </button>
                            </td>
                        </tr>
                        <div class="modal fade" id="editTemplateModal{{ $template->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit Template</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="editTemplateForm" action="{{ route('tamplate.update', $template->id) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="editName">Template Name</label>
                                                <input type="text" class="form-control" id="editName"
                                                    name="namatemplate" required value="{{ $template->namatemplate }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="editTemplate">Upload Template</label>
                                                <input type="file" class="form-control" id="template" name="template">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary"
                                            onclick="document.getElementById('editTemplateForm').submit();">Save
                                            Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
