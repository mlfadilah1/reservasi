@extends('customer.app')

@section('content')
<div class="container-fluid contact py-6 wow bounceInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row g-0">
            <div class="col-12">
                <div class="text-center">
                    <small class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">Rating Menu</small>
                    {{-- <h1 class="display-5 mb-5">Pesanan Anda</h1> --}}
                </div>
                <div class="container">
                        <div class="form-header">
                            <h2>{{ $datareservasi->nama_menu }}</h2>
                            <!-- Foto Menu -->
                            <div class="menu-image">
                                <img src="{{ url('storage/menu/' . $datareservasi->foto) }}" alt="{{ $datareservasi->foto }}" class="img-fluid">
                            </div>
                        </div>
                        
                        <!-- Formulir Rating -->
                        <form action="{{ route('submitrating', ['id_menu' => $datareservasi->id_menu]) }}" id="ratingForm" method="POST">
                            @csrf
                            <input type="hidden" name="id_menu" value="{{ $datareservasi->id_menu }}">
                            <input type="hidden" name="id_reservasi" value="{{ $id_reservasi }}">
                            <input type="hidden" name="id_user" value="{{ Auth::id() }}">
                
                            <div class="form-group">
                                <label for="rating">Bintang:</label>
                                <div class="stars">
                                    <input type="radio" id="star5" name="bintang" value="5">
                                    <label for="star5" class="star">&#9733;</label>
                                    <input type="radio" id="star4" name="bintang" value="4">
                                    <label for="star4" class="star">&#9733;</label>
                                    <input type="radio" id="star3" name="bintang" value="3">
                                    <label for="star3" class="star">&#9733;</label>
                                    <input type="radio" id="star2" name="bintang" value="2">
                                    <label for="star2" class="star">&#9733;</label>
                                    <input type="radio" id="star1" name="bintang" value="1">
                                    <label for="star1" class="star">&#9733;</label>
                                </div>
                            </div>
                
                            <div class="form-group">
                                <label for="review">Ulasan:</label>
                                <textarea id="review" name="ulasan" rows="4" class="form-control" placeholder="Tulis ulasan Anda"></textarea>
                            </div>
                
                            <button type="submit" class="btn btn-primary" id="submitButton">Kirim Rating</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<!-- Inline CSS -->
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }

    .rating-form-container {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 0 auto;
    }

    .form-header {
        text-align: center;
    }

    .form-header h2 {
        margin-bottom: 15px;
    }

    .menu-image {
        margin-bottom: 15px;
    }

    .menu-image img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }

    label {
        display: block;
        margin: 10px 0 5px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    input[type="radio"] {
        display: none;
    }

    .stars {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        margin: 10px 0;
    }

    .stars label {
        font-size: 1.5em;
        color: #ccc;
        cursor: pointer;
        margin-left: 5px;
    }

    .stars input:checked ~ label,
    .stars label:hover,
    .stars label:hover ~ label {
        color: gold;
    }

    textarea.form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        resize: vertical;
    }

    button.btn-primary {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1em;
        transition: background-color 0.3s;
    }

    button.btn-primary:hover {
        background-color: #218838;
    }
</style>

<!-- Inline JavaScript -->
<script>
    document.getElementById('ratingForm').addEventListener('submit', function(event) {
        var submitButton = document.getElementById('submitButton');
        submitButton.disabled = true;
        submitButton.innerHTML = 'Mengirim...';
    });
</script>
