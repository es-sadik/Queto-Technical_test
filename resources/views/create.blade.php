@extends('master')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card rounded-4" >
            <h3 class="text-primary my-5 text-center text-bold">
                Ajouter Produit :
            </h3>
            <form class="p-5" method="post" action="{{ route('addProductInStock') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-label-form" for="product"> Produit :</label>
                            <div class="col-sm-10">
                                <select name="product" class="form-control">
                                    @if (count($produits) > 0)
                                        @foreach ($produits as $produit)
                                            <option value="{{ $produit->id }}">{{ $produit->libelle }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-label-form"for="quantity"> Quantité/Poids :</label>
                            <div class="col-sm-10">
                                <input type="text" name="quantity" id="quantity" class="form-control" />
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-sm-2 col-label-form" for="expiration_date">Date d'expiration :</label>
                            <div class="col-sm-10">
                                <input type="date" name="expiration_date" id="expiration_date" class="form-control" >
                            </div>
                        </div>

                        <div class="text-center">
                            <input type="submit" class="btn btn-primary" value="Ajouter" />
                        </div>
            </form>
</div>
@endsection
