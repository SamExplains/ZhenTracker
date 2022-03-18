@extends('layouts.app')

@section('content')
  <div class="container-fluid">

    <div class="row">

      <div class="col-lg-6 col-12 ml-0 pl-0 mr-0 pr-0">
        <accounts-and-company-associated-component/>
      </div>

      <div class="col-lg-6 col-12 mr-0 pr-0">
        <new-user-with-company-component/>
      </div>

    </div>
  </div>
@endsection
