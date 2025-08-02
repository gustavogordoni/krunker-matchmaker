@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 text-center">Matchmaker Krunker</h2>

        <!-- Botão de Filtros -->
        <div class="text-center mb-3">
            <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse"
                aria-expanded="false" aria-controls="filterCollapse">
                <i class="bi bi-funnel"></i> Filtros
            </button>
        </div>

        <!-- Filtros -->
        <div class="collapse show" id="filterCollapse">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form id="filterForm" class="row g-4">
                        <!-- Regiões -->
                        <div class="col-md-6 border-end ps-5 pt-2">
                            <label class="form-label fw-bold">🌍 Regiões:</label>
                            <div class="row row-cols-2 row-cols-md-3">
                                @php
                                    $regions = [
                                        'MBI' => 'Mumbai',
                                        'NY' => 'New York',
                                        'FRA' => 'Frankfurt',
                                        'SIN' => 'Singapore',
                                        'DAL' => 'Dallas',
                                        'SYD' => 'Sydney',
                                        'MIA' => 'Miami',
                                        'BHN' => 'Middle East',
                                        'TOK' => 'Tokyo',
                                        'BRZ' => 'Brazil',
                                        'AFR' => 'South Africa',
                                        'LON' => 'London',
                                        'CHI' => 'China',
                                        'SV' => 'Silicon Valley',
                                        'STL' => 'Seattle',
                                        'MX' => 'Mexico',
                                        'SSS' => 'Super Secret Servers',
                                    ];
                                @endphp

                                @foreach ($regions as $code => $label)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="regions[]"
                                            value="{{ $code }}" id="region_{{ $code }}">
                                        <label class="form-check-label"
                                            for="region_{{ $code }}">{{ $label }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Modos -->
                        <div class="col-md-6 border-start ps-5 pt-2">
                            <label class="form-label fw-bold">🎯 Modos:</label>
                            <div class="row row-cols-1 row-cols-md-2">
                                @php
                                    $gamemodes = [
                                        'Free for All',
                                        'Team Deathmatch',
                                        'Hardpoint',
                                        'Capture the Flag',
                                        'Parkour',
                                        'Hide & Seek',
                                        'Infected',
                                        'Race',
                                        'Last Man Standing',
                                        'Simon Says',
                                        'Gun Game',
                                        'Prop Hunt',
                                        'Boss Hunt',
                                        'Classic FFA',
                                        'Deposit',
                                        'Stalker',
                                        'King of the Hill',
                                        'One in the Chamber',
                                        'Trade',
                                        'Kill Confirmed',
                                        'Defuse',
                                        'Sharp Shooter',
                                        'Traitor',
                                        'Raid',
                                        'Blitz',
                                        'Domination',
                                        'Squad Deathmatch',
                                        'Kranked FFA',
                                        'Team Defender',
                                        'Deposit FFA',
                                        'Chaos Snipers',
                                        'Bighead FFA',
                                    ];
                                @endphp
                                @foreach ($gamemodes as $mode)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="gamemodes[]"
                                            value="{{ $mode }}" id="mode_{{ Str::slug($mode) }}">
                                        <label class="form-check-label"
                                            for="mode_{{ Str::slug($mode) }}">{{ $mode }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Custom Match Checkbox -->
                        {{-- <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="includeCustom" id="includeCustom">
                                <label class="form-check-label" for="includeCustom">Incluir partidas customizadas</label>
                            </div>
                        </div> --}}

                        <!-- Inputs numéricos -->
                        <div class="col-6 col-md-4">
                            <label class="form-label">👥 Mín. Jogadores</label>
                            <input type="number" class="form-control" name="minPlayers" value="4" min="0">
                        </div>
                        <div class="col-6 col-md-4">
                            <label class="form-label">👥 Máx. Jogadores</label>
                            <input type="number" class="form-control" name="maxPlayers" value="8" min="0">
                        </div>
                        <div class="col-6 col-md-4">
                            <label class="form-label">⏳ Tempo Restante (segundos)</label>
                            <input type="number" class="form-control" name="minRemainingTime" value="240"
                                min="0">
                        </div>

                        <div class="col-12 col-md-12 align-self-end">
                            <button type="submit" class="btn btn-primary w-100">🔍 Buscar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row" id="gamesContainer">            
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('filterForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = new FormData(this);
            const params = new URLSearchParams();

            for (const [key, value] of form.entries()) {
                params.append(key, value);
            }

            fetch('/matchmaker?' + params.toString())
                .then(res => res.json())
                .then(data => {
                    console.log("Dados recebidos:", data);
                    const container = document.getElementById('gamesContainer');
                    container.innerHTML = '';

                    if (!data.length) {
                        container.innerHTML =
                            '<div class="alert alert-warning w-100 text-center">Nenhuma partida encontrada.</div>';
                        return;
                    }

                    data.forEach(game => {
                        const [gameID, region, players, maxPlayers, info, remaining] = game;
                        const html = `
                            <div class="col-md-3 mb-3">
                                <div class="card shadow-sm">
                                    <img src="https://assets.krunker.io/img/maps/map_${info.m}.png" class="card-img-top">
                                    <div class="card-body">
                                        <h5 class="card-title">${info.i} (${Math.floor(remaining / 60)}m ${remaining % 60}s)</h5>
                                        <h6 class="card-title">${players}/${maxPlayers} Jogadores</h6>                                        
                                        <p class="card-text">
                                            <strong>Modo:</strong> ${info.gamemodeName}<br>
                                            <strong>Região:</strong> ${region}<br>
                                            <strong>Tempo:</strong> ${remaining}s
                                        </p>

                                        <div class="d-flex gap-2">
                                            <a href="https://krunker.io/?game=${gameID}" target="_blank" class="btn btn-success btn-sm">Entrar</a>
                                            <button class="btn btn-warning btn-sm" onclick="copyToClipboard('https://krunker.io/?game=${gameID}')">Copiar</button>                                           
                                            <button class="btn btn-info btn-sm" onclick="showPlayers('${gameID}')">Jogadores</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        `;
                        container.innerHTML += html;
                    });
                })
                .catch(err => {
                    console.error("Erro ao buscar jogos:", err);
                    document.getElementById('gamesContainer').innerHTML =
                        '<div class="alert alert-danger w-100 text-center">Erro ao carregar jogos.</div>';
                });
        });

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert("Link copiado para a área de transferência!");
            }).catch(err => {
                console.error("Erro ao copiar:", err);
                alert("Falha ao copiar o link.");
            });
        }
    </script>
@endsection
