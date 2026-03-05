const cartDrawer = document.getElementById("cart-drawer");
const cartOverlay = document.getElementById("cart-overlay");
const cartClose = document.getElementById("cart-close");
const cartBtn = document.getElementById("cart-btn");
const cartCount = document.getElementById("cart-count");
const cartTotal = document.getElementById("cart-total");
const cartItems = document.getElementById("cart-items");
const cartBadge = document.getElementById("cart-badge");

function openCart() {
    cartDrawer.classList.add("is-open");
    cartOverlay.classList.add("is-open");
    cartDrawer.setAttribute("aria-hidden", "false");
    cartOverlay.setAttribute("aria-hidden", "false");
    loadCartData();
}

function closeCart() {
    cartDrawer.classList.remove("is-open");
    cartOverlay.classList.remove("is-open");
    cartDrawer.setAttribute("aria-hidden", "true");
    cartOverlay.setAttribute("aria-hidden", "true");
}

cartBtn.addEventListener("click", openCart);
cartClose.addEventListener("click", closeCart);
cartOverlay.addEventListener("click", closeCart);

document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeCart();
});

async function loadCartData() {
    const response = await fetch("/cart/data");
    const data = await response.json();
    renderCart(data);
}

function renderCart(data) {
    updateBadge(data.count);

    if (data.items.length === 0) {
        cartItems.innerHTML =
            '<p class="cart-drawer__empty">Votre panier est vide.</p>';
        cartTotal.textContent = "0,00";
        return;
    }

    cartTotal.textContent = formatPrice(data.total);
    cartItems.innerHTML = data.items.map(renderItem).join("");

    cartItems.querySelectorAll(".cart-item__qty-select").forEach((select) => {
        select.addEventListener("change", async (e) => {
            await updateQuantity(e.target.dataset.id, e.target.value);
        });
    });

    cartItems.querySelectorAll(".cart-item__remove").forEach((btn) => {
        btn.addEventListener("click", async (e) => {
            await removeItem(e.target.dataset.id);
        });
    });
}

function renderItem(item) {
    const tags = [item.category, item.style]
        .filter(Boolean)
        .map((t) => `<span class="cart-item__tag">${t}</span>`)
        .join("");

    const options = Array.from({ length: 10 }, (_, i) => {
        const val = i + 1;
        const selected = val === item.quantity ? "selected" : "";
        return `<option value="${val}" ${selected}>${val}</option>`;
    }).join("");

    return `
        <div class="cart-item" data-id="${item.id}">
            <div class="cart-item__thumbnail">▶</div>
            <div class="cart-item__info">
                <span class="cart-item__name">${item.name}</span>
                <div class="cart-item__tags">${tags}</div>
                <div class="cart-item__quantity">
                    Qté :
                    <select class="cart-item__qty-select" data-id="${item.id}">
                        ${options}
                    </select>
                </div>
            </div>
            <div class="cart-item__actions">
                <span class="cart-item__price">${formatPrice(item.subtotal)} €</span>
                <button class="cart-item__remove" data-id="${item.id}">Supprimer</button>
            </div>
        </div>
    `;
}

async function updateQuantity(id, quantity) {
    const body = new URLSearchParams({ quantity });
    const res = await fetch(`/cart/update/${id}`, { method: "POST", body });
    const data = await res.json();
    updateBadge(data.cartCount);
    await loadCartData();
}

async function removeItem(id) {
    const res = await fetch(`/cart/remove/${id}`, { method: "POST" });
    const data = await res.json();
    updateBadge(data.cartCount);
    await loadCartData();
}

async function addToCart(id) {
    const res = await fetch(`/cart/add/${id}`, { method: "POST" });
    const data = await res.json();
    updateBadge(data.cartCount);
    openCart();
}

function updateBadge(count) {
    cartCount.textContent = count;
    if (cartBadge) {
        cartBadge.textContent = count;
        cartBadge.classList.toggle("is-hidden", count === 0);
    }
}

function formatPrice(value) {
    return Number(value).toLocaleString("fr-FR", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });
}
