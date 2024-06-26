@extends('User.layout.app')

@section('title', 'Result')

@section('main_content')

    <div class="card m-5 h-100 p-5">
        <h1>Hasil Deteksi</h1>
        <table class="table table-light table-striped">
            <th>
                <td>
                    Gambar
                </td>
                <td>
                    Tanggal
                </td>
            </th>
            <tbody>
                @foreach ($data as $result)
                    <tr>
                        <td>
                            <img src="{{ asset('img/' + Auth::guard()->user()->id + '/' + $result->image) }}" alt="">
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
    </div>


</div>
</div>
@endsection
