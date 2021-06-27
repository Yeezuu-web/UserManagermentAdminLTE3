<div class="card">
    <div class="card-header">File in schedule</div>
    <div class="card-body">
        <table class="table" id="files_table">
            <thead>
                <tr>
                    <th>File ID</th>
                    <th width="150">Order</th>
                    <th width="80"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fileSchedules as $index => $fileSchedule)
                    <tr>
                        <td>
                            <div class="form-group" wire:ignore>
                                <select
                                    name="fileSchedules[{{$index}}][file_id]"
                                    wire:model="fileSchedules.{{$index}}.file_id"
                                    class="form-control form-control-sm select2 selectFileSchedules">
                                    <option value="">--- Select File ---</option>
                                    @foreach ($files as $file)
                                        <option value="{{$file->id}}">
                                            {{$file->fileId}}-{{$file->title_of_content}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-sort"></i>
                                    </span>
                                </div>
                                <input  type="number" 
                                        disabled
                                        min="1"
                                        name="fileSchedules[{{$index}}][position]" 
                                        wire:model="fileSchedules.{{$index}}.position"
                                        class="form-control form-control-sm" />
                            </div>
                        </td>
                        <td>
                            <button 
                            wire:click.prevent="removeRow({{$index}})" 
                            class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="form-group col-md-12">
                <button wire:click.prevent="addFile()" class="btn btn-secondary btn-sm">Add File</button>
            </div>
        </div>
    </div>
</div>