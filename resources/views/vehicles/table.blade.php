@if(auth()->user()->level == 'admin')

        
<a href="{{ route('exportvehicle') }}" class="btn btn-success">Export To Excel</a>
<br>
<br>
@endif

<table id="data_table" class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Reg #</th>
            <th>Category</th>
            <th>Plat Number</th>
            <th>Status</th>
            <th>Created At</th>
            <th class="nosort">Operation</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($vehicles as $key => $vehicle)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $vehicle->registration_number }}</td>
            <td>{{ $vehicle->category }}</td>
            <td>{{ $vehicle->plat_number }}</td>
            <td>{{ $vehicle->status == 1 ? "Active" : "InActive" }}</td>
            <td>{{ $vehicle->created_at->format('Y/m/d h:i:s') }}</td>
            <td>
                <div class="btn-group table-actions">
                    <a href="#" data-toggle="modal" data-target="#show{{ $key }}"><i class="ik ik-eye"></i></a>
                    <a href="{{ route('vehicles.edit', $vehicle->id) }}"><i class="ik ik-edit-2"></i></a>
                    
                    <a href="#"  data-toggle="modal" data-target="#delete{{ $key }}"><i class="ik ik-trash-2"></i></a>

                    @csrf
                    <a href="{{ route('exitvehicle', $vehicle->id)}}" ><i class="ik ik-log-out"></i></a>
                </div>
            </td>
            <td></td>
        </tr>
        @include('vehicles.show')
        @include('vehicles.delete')
        @endforeach

       

    </tbody>
</table>


