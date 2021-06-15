<div class="card col-md-12">
    <div class="card-header">Segment</div>
    <div class="card-body">
        <table class="table" id="products_table">
            <thead>
            <tr>
                <th>Break</th>
                <th>SOM</th>
                <th>EOM</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($breaks as $index => $break)
                <tr>
                    <td>
                        <select name="breaks[{{$index}}][segment_id]" 
                            wire:model="breaks.{{$index}}.segment_id"
                            class="form-control form-control-sm">
                            <option value="">-- choose break --</option>
                            @foreach ($allSegments as $segment)
                                <option value="{{ $segment->id }}">{{ $segment->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-clock"></i>
                                </span>
                            </div>
                            <input  type="text" 
                                    name="breaks[{{$index}}][som]" 
                                    class="form-control form-control-sm" 
                                    wire:model="breaks.{{$index}}.som" />
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-clock"></i>
                                </span>
                            </div>
                            <input  type="text" 
                                    name="breaks[{{$index}}][eom]" 
                                    class="form-control form-control-sm" 
                                    wire:model="breaks.{{$index}}.eom" />
                        </div>
                    </td>
                    <td>
                        <a href="#" wire:click.prevent="removeBreak({{$index}})">Delete</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="form-group col-md-12">
                <button wire:click.prevent="addBreak()" class="btn btn-sm btn-secondary">Add Break</button>
            </div> 
        </div>
    </div>
</div>
    

