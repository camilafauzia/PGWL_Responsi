@extends('layouts.template')

@section('content')

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h3>Data Mahasiswa</h3>
        </div>
        <div class="card-body"></div>
        <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Kelas</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>nama</td>
            <td>A</td>
        <tr>
            <td>2</td>
            <td>nama2</td>
            <td>A</td>
        </tr>
        <tr>
            <td>3</td>
            <td>nama3</td>
            <td>A</td>
        </tr>
        <tr>
            <td>4</td>
            <td>nama4</td>
            <td>B</td>
        </tr>
        </tr>
    </tbody>
</table>
    </div>
</div>
@endsection