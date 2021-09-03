<div class="col mb-4">
    <div class="card shadow bg-light">
        <img src="{{ $collectionPokemons[$pokemon['name']]['image'] }}"
            class="card-img-top px-4" alt="{{ $pokemon['name'] }} image">

        <div class="card-body">
            <h5 class="card-title text-capitalize text-center bg-dark py-2">
                <a href="{{ route('page.show', $collectionPokemons[$pokemon['name']]['id']) }}" target="_blank"
                    class="text-white text-decoration-none">
                    {{ $collectionPokemons[$pokemon['name']]['name_f'] }}
                </a>
            </h5>

            <div class="text-center">
                @foreach ($collectionPokemons[$pokemon['name']]['types'] as $p)
                    <span class="badge {{ $p->type->name }} px-2 py-1 text-capitalize">
                        {{ $p->type->name }}
                    </span>
                @endforeach
            </div>

            <hr>

            <div class="d-flex justify-content-around align-items-center">
                <div class="d-flex align-items-center">
                    <img src="https://img.icons8.com/ios-glyphs/30/000000/height.png"/>
                    <p class="card-text ml-2">
                        {{ $collectionPokemons[$pokemon['name']]['height'] }}
                    </p>
                </div>
                <div class="d-flex align-items-center">
                    <img src="https://img.icons8.com/ios-glyphs/30/000000/industrial-scales.png"/>
                    <p class="card-text ml-2">
                        {{ $collectionPokemons[$pokemon['name']]['weight'] }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
