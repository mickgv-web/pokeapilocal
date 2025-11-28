let offset = 10; // ya hemos mostrado los 10 primeros con PHP
const limit = 10;
const grid = document.getElementById("pokemonGrid");
const status = document.getElementById("status");
let loading = false;
let totalPokemons = null;

function loadMore() {
  if (loading) return;
  loading = true;
  status.textContent = "Cargando…";

  fetch(`api.php?offset=${offset}&limit=${limit}`)
    .then((res) => res.json())
    .then((data) => {
      if (totalPokemons === null) {
        totalPokemons = data.count;
      }

      const pokemons = data.results;
      offset += limit;

      pokemons.forEach((poke) => {
        const card = document.createElement("div");
        card.className = "card";
        card.innerHTML = `
          <h3>#${poke.id} ${poke.nombre}</h3>
          <p><strong>Tipos:</strong>
            ${poke.tipo
              .map((t) => `<span class="badge ${t.toLowerCase()}">${t}</span>`)
              .join(" ")}
          </p>
          <p><strong>Altura:</strong> ${poke.altura} m</p>
          <p><strong>Peso:</strong> ${poke.peso} kg</p>
        `;
        grid.appendChild(card);
      });

      if (offset >= totalPokemons) {
        status.textContent = "No hay más Pokémon";
        window.removeEventListener("scroll", handleScroll);
      } else {
        status.textContent = "";
      }

      loading = false;
    })
    .catch((err) => {
      status.textContent = "Error al cargar";
      console.error(err);
      loading = false;
    });
}

function handleScroll() {
  if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 400) {
    loadMore();
  }
}

window.addEventListener("scroll", handleScroll);

function ensureScroll() {
  if (
    document.body.offsetHeight <= window.innerHeight &&
    (totalPokemons === null || offset < totalPokemons)
  ) {
    loadMore();
    setTimeout(ensureScroll, 200);
  }
}

window.addEventListener("load", ensureScroll);
