@can($importGate)
    <a class="btn btn-xs btn-primary" href="{{ route('admin.' . $crudRoutePart . '.import', $row->id) }}">
        Import
    </a>
@endcan