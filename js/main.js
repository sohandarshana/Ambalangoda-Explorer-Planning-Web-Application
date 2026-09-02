// js/main.js

const API_BASE = 'api';

// --- Itinerary Management ---
function getItinerary() {
  const data = localStorage.getItem('itinerary');
  return data ? JSON.parse(data) : [];
}

function setItinerary(places) {
  localStorage.setItem('itinerary', JSON.stringify(places));
  updateCartCount();
}

function togglePlaceInItinerary(place) {
  let itinerary = getItinerary();
  const index = itinerary.findIndex(p => p.id === place.id);
  
  if (index !== -1) {
    itinerary.splice(index, 1);
  } else {
    itinerary.push(place);
  }
  setItinerary(itinerary);
}

function isPlaceInItinerary(id) {
  return getItinerary().some(p => p.id === id);
}

function updateCartCount() {
  const countEls = document.querySelectorAll('#cart-count');
  const count = getItinerary().length;
  countEls.forEach(el => {
    el.textContent = count;
  });
}

// Initialize count on load
document.addEventListener('DOMContentLoaded', updateCartCount);


// --- API Fetching and Rendering ---

async function fetchPlacesAndCategories() {
  try {
    const [placesRes, categoriesRes] = await Promise.all([
      fetch(`${API_BASE}/get_places.php`),
      fetch(`${API_BASE}/get_categories.php`)
    ]);
    
    const places = await placesRes.json();
    const categories = await categoriesRes.json();
    
    renderCategories(categories, places);
    renderPlaces(places);
  } catch (err) {
    console.error(err);
    document.getElementById('places-container').innerHTML = '<div class="text-red-500">Failed to load places.</div>';
  }
}

function renderCategories(categories, allPlaces) {
  const container = document.getElementById('categories-container');
  if (!container) return;
  
  let html = `<button onclick="filterPlaces('all')" class="rounded-full border px-4 py-1.5 text-sm font-medium transition-colors bg-ink text-sand-50 border-ink">All</button>`;
  
  categories.forEach(c => {
    html += `<button onclick="filterPlaces('${c.id}')" class="rounded-full border px-4 py-1.5 text-sm font-medium transition-colors border-sand-300 text-ink-700 hover:border-ink-500">${c.label}</button>`;
  });
  
  container.innerHTML = html;
  window.allPlacesData = allPlaces;
}

window.currentCategory = 'all';

window.filterPlaces = function(categoryId) {
  if (!window.allPlacesData) return;
  window.currentCategory = categoryId;
  applyFilters();
}

function applyFilters() {
  if (!window.allPlacesData) return;
  const searchTerm = document.getElementById('searchInput') ? document.getElementById('searchInput').value.toLowerCase() : '';
  
  const filtered = window.allPlacesData.filter(p => {
    const matchCategory = window.currentCategory === 'all' || p.category_id === window.currentCategory;
    const matchSearch = p.name.toLowerCase().includes(searchTerm) || p.summary.toLowerCase().includes(searchTerm);
    return matchCategory && matchSearch;
  });
  renderPlaces(filtered);
}

document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('searchInput');
  if (searchInput) {
    searchInput.addEventListener('input', applyFilters);
  }
});

function renderPlaces(places) {
  const container = document.getElementById('places-container');
  if (!container) return;
  
  if (places.length === 0) {
    container.innerHTML = '<div class="text-ink-500">No places found.</div>';
    return;
  }
  
  let html = '';
  places.forEach(place => {
    const inTrip = isPlaceInItinerary(place.id);
    const imgSrc = place.imageUrl.startsWith('/') ? place.imageUrl.substring(1) : place.imageUrl;
    html += `
      <a href="place.html?id=${place.id}" class="group relative flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-sand-200 transition-all hover:shadow-md hover:ring-sand-300">
        <div class="relative aspect-[4/3] w-full overflow-hidden bg-sand-100">
          <img src="${imgSrc}" alt="${place.name}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
          <div class="absolute inset-0 bg-gradient-to-t from-ink/60 to-transparent"></div>
          <div class="absolute bottom-4 left-4 right-4">
            <span class="mb-2 inline-block rounded-full px-2.5 py-1 text-xs font-semibold ${place.pill}">
              ${place.category_label}
            </span>
            <h3 class="font-display text-xl font-bold text-sand-50">${place.name}</h3>
          </div>
        </div>
        <div class="flex flex-1 flex-col p-5">
          <div class="flex items-center gap-4 text-sm text-ink-500 mb-3">
            <span>${place.distanceKm} km away</span>
            <span>${place.visitDurationMin} mins</span>
          </div>
          <p class="mb-6 flex-1 text-sm text-ink-700">${place.summary}</p>
          <button onclick="event.preventDefault(); togglePlaceFromCard('${place.id}')" class="mt-auto flex w-full items-center justify-center gap-2 rounded-xl py-2.5 text-sm font-semibold transition-colors ${inTrip ? 'bg-sand-100 text-ink-500 hover:bg-sand-200 hover:text-ink-700' : 'bg-ochre-600 text-sand-50 hover:bg-ochre-500'}">
            ${inTrip ? 'Remove from day' : 'Add to day'}
          </button>
        </div>
      </a>
    `;
  });
  
  container.innerHTML = html;
}

window.togglePlaceFromCard = async function(id) {
  if (!window.allPlacesData) return;
  const place = window.allPlacesData.find(p => p.id === id);
  if (place) {
    togglePlaceInItinerary(place);
    renderPlaces(window.allPlacesData);
  }
}

async function fetchPlaceDetails(id) {
  try {
    const res = await fetch(`${API_BASE}/get_place.php?id=${id}`);
    const place = await res.json();
    
    if (place.error) {
      document.getElementById('place-detail-container').innerHTML = `<div class="text-center py-12 text-ink-500">${place.error}</div>`;
      return;
    }
    
    const inTrip = isPlaceInItinerary(place.id);
    window.currentPlace = place;
    
    let highlightsHtml = '';
    if (place.highlights && place.highlights.length > 0) {
      highlightsHtml = `
        <h2 class="mt-8 font-display text-2xl font-bold">Highlights</h2>
        <ul class="mt-4 space-y-3">
          ${place.highlights.map(h => `<li class="flex items-start gap-3 text-ink-700"><svg class="mt-0.5 h-5 w-5 shrink-0 text-ochre-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg> ${h}</li>`).join('')}
        </ul>
      `;
    }
    
    const html = `
      <div class="mx-auto max-w-6xl px-6">
        <a href="attractions.html" class="inline-flex items-center gap-2 text-sm font-medium text-ink-500 hover:text-ink">
          ← Back to places
        </a>
        
        <div class="mt-8 grid gap-12 lg:grid-cols-[1fr_400px]">
          <div>
            <span class="mb-4 inline-block rounded-full px-3 py-1 text-sm font-medium ${place.pill}">${place.category_label}</span>
            <h1 class="font-display text-4xl font-bold tracking-tight sm:text-5xl">${place.name}</h1>
            
            <p class="mt-6 text-xl leading-relaxed text-ink-700">${place.description}</p>
            
            ${highlightsHtml}
          </div>
          
          <div>
            <div class="sticky top-24 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-sand-200">
              <div class="aspect-[4/3] w-full bg-sand-200">
                <img src="${place.imageUrl ? place.imageUrl.replace(/^\//, '') : ''}" alt="${place.name}" class="h-full w-full object-cover" onerror="this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center text-sand-300\'><svg width=\'48\' height=\'48\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'1\'><rect width=\'18\' height=\'18\' x=\'3\' y=\'3\' rx=\'2\'/><circle cx=\'9\' cy=\'9\' r=\'2\'/><path d=\'m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21\'/></svg></div>'">
              </div>
              
              <div class="p-6">
                <button onclick="toggleCurrentPlace()" id="detail-add-btn" class="flex w-full items-center justify-center gap-2 rounded-xl py-3 text-base font-semibold transition-colors ${inTrip ? 'bg-sand-100 text-ink-500 hover:bg-sand-200' : 'bg-ochre-600 text-sand-50 hover:bg-ochre-500'}">
                  ${inTrip ? 'Remove from day' : 'Add to day'}
                </button>
                
                <hr class="my-6 border-sand-200">
                
                <dl class="space-y-4 text-sm">
                  <div class="flex gap-4">
                    <dt class="w-24 shrink-0 text-ink-500">Duration</dt>
                    <dd class="font-medium text-ink">${place.visitDurationMin} minutes</dd>
                  </div>
                  <div class="flex gap-4">
                    <dt class="w-24 shrink-0 text-ink-500">Hours</dt>
                    <dd class="font-medium text-ink">${place.openingHours}</dd>
                  </div>
                  <div class="flex gap-4">
                    <dt class="w-24 shrink-0 text-ink-500">Entry</dt>
                    <dd class="font-medium text-ink">${place.entryFee}</dd>
                  </div>
                </dl>
              </div>
            </div>
          </div>
        </div>
      </div>
    `;
    
    document.getElementById('place-detail-container').innerHTML = html;
  } catch (err) {
    console.error(err);
    document.getElementById('place-detail-container').innerHTML = '<div class="text-center py-12 text-red-500">Failed to load place.</div>';
  }
}

window.toggleCurrentPlace = function() {
  if (window.currentPlace) {
    togglePlaceInItinerary(window.currentPlace);
    const inTrip = isPlaceInItinerary(window.currentPlace.id);
    const btn = document.getElementById('detail-add-btn');
    if (inTrip) {
      btn.className = "flex w-full items-center justify-center gap-2 rounded-xl py-3 text-base font-semibold transition-colors bg-sand-100 text-ink-500 hover:bg-sand-200";
      btn.textContent = "Remove from day";
    } else {
      btn.className = "flex w-full items-center justify-center gap-2 rounded-xl py-3 text-base font-semibold transition-colors bg-ochre-600 text-sand-50 hover:bg-ochre-500";
      btn.textContent = "Add to day";
    }
  }
}

function renderPlanner() {
  const container = document.getElementById('itinerary-list');
  if (!container) return;
  
  const itinerary = getItinerary();
  
  if (itinerary.length === 0) {
    container.innerHTML = `
      <div class="rounded-2xl border border-dashed border-sand-300 bg-sand-50/50 p-12 text-center">
        <h3 class="font-display text-lg font-semibold text-ink">Your day is empty</h3>
        <p class="mt-2 text-ink-500">Start exploring places to build your itinerary.</p>
        <a href="attractions.html" class="mt-6 inline-flex rounded-full bg-ochre-600 px-6 py-2.5 text-sm font-semibold text-sand-50 transition-colors hover:bg-ochre-500">Explore places</a>
      </div>
    `;
    return;
  }
  
  let html = '';
  itinerary.forEach((place, index) => {
    html += `
      <div class="group relative flex items-center gap-4 rounded-2xl border border-sand-200 bg-white p-4 shadow-sm transition-all hover:shadow-md">
        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-sand-100 text-sm font-bold text-ink-500">
          ${index + 1}
        </div>
        
        <img src="${place.imageUrl ? place.imageUrl.replace(/^\//, '') : ''}" alt="" class="h-16 w-16 shrink-0 rounded-xl object-cover bg-sand-200" onerror="this.src='';this.classList.add('bg-sand-200')">
        
        <div class="flex flex-1 flex-col min-w-0">
          <h4 class="truncate font-display font-semibold text-ink">${place.name}</h4>
          <p class="truncate text-sm text-ink-500">${place.visitDurationMin} mins · ${place.category_label}</p>
        </div>
        
        <button onclick="removePlannerItem('${place.id}')" class="rounded-lg p-2 text-ink-400 opacity-0 transition-all hover:bg-coral-50 hover:text-coral-600 group-hover:opacity-100">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>
        </button>
      </div>
    `;
  });
  
  container.innerHTML = html;
}

window.removePlannerItem = function(id) {
  let itinerary = getItinerary();
  itinerary = itinerary.filter(p => p.id !== id);
  setItinerary(itinerary);
  renderPlanner();
}
