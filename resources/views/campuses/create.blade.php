@extends('layouts.main')

@section('title', 'Criar campus')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Novo campus</div>

                <div class="card-body">
                    @if($errors)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger mt-4" role="alert">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif

                    <form action="{{ route('campus.store') }}" method="post" class="mt-4" autocomplete="off">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nome:</label>
                                <input type="text" class="form-control" name="name" id="name" required>
                            </div>

                            <div class="col-md-6">
                                <label for="coordinator_id" class="form-label">Coordenador:</label>
                                <select class="form-select" name="coordinator_id" id="coordinator_id" required>
                                    <option value="">Selecione um coordenador</option>
                                    @foreach($coordinators as $coordinator)
                                        <option value="{{ $coordinator->id }}">{{ $coordinator->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-3">
                                <label for="zip_code" class="form-label">CEP:</label>
                                <input type="text" class="form-control" name="zip_code" id="zip_code" required>
                            </div>

                            <div class="col-md-4">
                                <label for="district" class="form-label">Bairro:</label>
                                <input type="text" class="form-control" name="district" id="district" required>
                            </div>

                            <div class="col-md-2">
                                <label for="state_id" class="form-label">Estado</label>
                                <select class="form-select" id="state_id" name="state_id">
                                    <option value="">Selecione um estado</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}">{{ $state->abbr }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="city_id" class="form-label">Cidade:</label>
                                <select class="form-select" name="city_id" id="city_id" required>
                                    <option value="">Selecione uma cidade</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-9">
                                <label for="address" class="form-label">Endereço:</label>
                                <input type="text" class="form-control" name="address" id="address" required>
                            </div>

                            <div class="col-md-3">
                                <label for="address_number" class="form-label">Número:</label>
                                <input type="text" class="form-control" name="address_number" id="address_number" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary mx-3">Cadastrar campus</button>
                            <a class="btn btn-danger" href="{{ route('campus.index') }}">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#zip_code').on('blur', function() {
            var cep = $(this).val().replace(/\D/g, '');

            if (cep.length != 8) {
                return;
            }

            $.ajax({
                url: 'https://viacep.com.br/ws/' + cep + '/json/',
                dataType: 'json',
                beforeSend: function() {
                    // Aqui você pode exibir algum indicador de carregamento
                },
                success: function(data) {
                    if (!('erro' in data)) {
                        $('#address').val(data.logradouro);
                        $('#district').val(data.bairro);
                        
                        var stateAbbr = data.uf;
                        $('#state_id option').filter(function() {
                            return $(this).text().toUpperCase() === stateAbbr.toUpperCase();
                        }).prop('selected', true);

                        var state_id = $('#state_id').val();
                        if (state_id) {
                            loadCities(state_id);
                        }

                        var cityName = data.localidade;
                        selectCityByName(cityName);
                    } else {
                        alert('CEP não encontrado.');
                    }
                },
                error: function() {
                    alert('Erro ao buscar CEP.');
                },
                complete: function() {
                    // Aqui você pode esconder o indicador de carregamento
                }
            });
        });
    });

    $('#state_id').on('change', function() {
        var state_id = $(this).val();

        if (!state_id) {
            $('#city_id').empty().append('<option value="">Selecione uma cidade</option>');
            return;
        }

        loadCities(state_id);
    });

    function loadCities(state_id) {
        $.ajax({
            url: '/api/cities/' + state_id,
            dataType: 'json',
            success: function(data) {
                $('#city_id').empty().append('<option value="">Selecione uma cidade</option>');
                $.each(data, function(key, value) {
                    $('#city_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            },
            error: function() {
                alert('Erro ao carregar cidades.');
            }
        });
    }

    function selectCityByName(cityName) {
        setTimeout(function() {
            $('#city_id option').filter(function() {
                return $(this).text().toUpperCase() === cityName.toUpperCase();
            }).prop('selected', true);
        }, 1000); // Esperar 1 segundo antes de selecionar a cidade
        console.log("ass")
    }
</script>
@endpush

@endsection
