@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>
            {{ ucfirst($category) }}
        </h1>
        <br>
    </div>
    <div class="container pt-5">
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Faculty ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Remarks</th>
                    <th>Part-timer</th>
                    <th>Graduate</th>
                    {{-- <th>Designation</th> --}}
                    <th>Program Head</th>
                    <th>Date Added</th>
                    <th>Edit | Delete</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($faculties as $faculty)
                    <tr>

                        <td>{{ $faculty->id_usep }}

                        </td>
                        <td>{{ $faculty->first_name }}
                            @if ($faculty->is($faculty->program_head->faculty))
                                (You)
                            @endif
                        </td>
                        <td>{{ $faculty->last_name }}</td>
                        <td>{{ $faculty->remarks }}</td>
                        <td>{{ $faculty->is_part_timer ? 'Yes' : 'No' }}</td>
                        <td>{{ $faculty->is_graduate ? 'Yes' : 'No' }}</td>
                        {{-- <td>{{ $faculty->designation_id }}</td> --}}
                        <td>{{ $faculty->program_head->name }}</td>

                        @php $dateTime = \Carbon\Carbon::parse($faculty->created_at); @endphp
                        <td>{{ $dateTime->toDateString() }}</td>
                        <td><a href="{{ route('faculty.edit', $faculty) }}">Edit</a> |
                            <form method="POST" action="{{ route('faculty.destroy', $faculty) }}">
                                @csrf
                                @method('delete')
                                <a href="{{ route('faculty.destroy', $faculty) }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();">Delete</a>
                            </form>
                        </td>


                    </tr>
                @endforeach

            </tbody>
        </table>
        <a href="{{route('faculty.create')}}"> Add a Faculty</a>
    </div>
    </body>
@endsection
