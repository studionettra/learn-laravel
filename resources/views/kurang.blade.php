@extends('main')
@section('content')

<br><br>
    <form action="{{ route('action-kurang') }}" method="post">
        @csrf
        <label for="">Angka 1</label>
        <input type="text" placeholder="Masukan Angka" name="angka_1">
        <br>
        +
        <br>

        <label for="">Angka 2</label>
        <input type="text" placeholder="Masukan Angka" name="angka_2">
        <br><br>
        <button type="submit">Hitung</button>
    </form>

    <h1>Jumlahnya : {{ $jumlahKurang }}</h1>

@endsection
