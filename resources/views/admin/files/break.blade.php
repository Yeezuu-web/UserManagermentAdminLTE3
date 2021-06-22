<div class="card">
    <div class="card-header">
        Break On Segment
    </div>

    <div class="card-body">
        <table class="table" id="breaks_table">
            <thead>
                <tr>
                    <th>Break</th>
                    <th>SOM</th>
                    <th>EOM</th>
                </tr>
            </thead>
            <tbody>
                <tr id="break0">
                    <td>
                        <select name="breaks[]" id="breaks0" class="form-control">
                            <option value="">-- choose product --</option>
                            @foreach ($breaks as $break)
                                <option value="{{ $break->id }}">
                                    {{ $break->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" name="soms[]" id="soms0" class="form-control timepicker" value="1" />
                    </td>
                    <td>
                        <input type="text" name="eoms[]" id="eoms0" class="form-control timepicker" value="1" />
                    </td>
                </tr>
                <tr id="break1"></tr>
            </tbody>
        </table>

        <div class="row">
            <div class="col-md-12">
                <button id="add_row" class="btn btn-default pull-left">+ Add Row</button>
                <button id='delete_row' class="pull-right btn btn-danger">- Delete Row</button>
            </div>
        </div>
    </div>
</div>