
const foodButton = document.getElementById("foodButton");
const categoryButton = document.getElementById("categoryButton");
const foodList = document.getElementById("foodList");
const categoryList = document.getElementById("categoryList");
const goodsContent = document.getElementById("goodsContent");



const catlist = document.getElementsByClassName('catlist');

Array.from(catlist).forEach(function(element) {
    element.addEventListener('click', function() {
        Array.from(catlist).forEach(function(el) {
            el.classList.remove('bg-cyan-500');
        });
        this.classList.add('bg-cyan-500');
        // GET so'rovi yuborish
        goodsContent.innerHTML = "";
        const dataId = this.dataset.id;
        fetch('/cp/gen/getgoodssale?id='+dataId)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text(); // Ma'lumotlarni JSON formatida o'qish
            })
            .then(data => {
                if(data != -1){
                    goodsContent.innerHTML = ''+data;
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    });
});

const searchInput = document.getElementById('search-input');

searchInput.addEventListener('keyup',()=>{
    // GET so'rovi yuborish
    goodsContent.innerHTML = "";
    var type = 1;
    if(categoryButton.classList.contains('active')){
       type = 2;
    }
    if(searchInput.value.length >= 3){
        fetch('/cp/gen/searchgoods?name='+searchInput.value+'&type='+type)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text(); // Ma'lumotlarni JSON formatida o'qish
            })
            .then(data => {
                if(data != -1){
                    goodsContent.innerHTML = ''+data;
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    }

});

foodButton.addEventListener("click", function () {
    // Sidebar changes
    foodList.classList.remove("hidden");
    categoryList.classList.add("hidden");
    foodButton.classList.add("bg-cyan-500");
    foodButton.classList.add("active");
    categoryButton.classList.remove("bg-cyan-500");
    categoryButton.classList.remove("active");
    categoryButton.classList.add("bg-transparent");

});

categoryButton.addEventListener("click", function () {
    // Sidebar changes
    categoryList.classList.remove("hidden");
    foodList.classList.add("hidden");
    categoryButton.classList.add("bg-cyan-500");
    categoryButton.classList.add("active");
    foodButton.classList.remove("bg-cyan-500");
    foodButton.classList.remove("active");
    foodButton.classList.add("bg-transparent");

});

foodList.classList.remove("hidden");
foodButton.classList.add("bg-cyan-500");

//dialog
const submitButton = document.getElementById("submitButton");
const customDialog = document.getElementById("customDialog");
const closeDialog = document.getElementById("closeDialog");
const listsales = document.getElementById("listsales");
const customDialogUsta = document.getElementById('customDialogUsta');
const customDialogUstabtn = document.getElementById('customDialogUstabtn');

// Open the dialog


// Close the dialog
closeDialog.addEventListener("click", () => {
    customDialog.classList.add("hidden");
});

// Add click handlers for cart items
document.addEventListener("click", (e) => {
    // Only open dialog when clicking name, price or image
    if (e.target.matches(".text-sm, img, h5")) {
        const cartItem = e.target.closest(".select-none.mb-3");
        if (cartItem) {
            const dialog = document.getElementById("cartItemDialog");
            const img = cartItem.querySelector("img").src;
            const title = cartItem.querySelector("h5").textContent;
            const price = cartItem.querySelector("p").textContent;

            // document.getElementById("dialogImage").src = img;
            document.getElementById("dialogTitle").textContent = title;
            document.getElementById("dialogPrice").textContent = price;

            dialog.classList.remove("hidden");
            document.body.style.overflow = "hidden";
        }
    }

    if (e.target.classList.contains('goods-items')) {
        const dataId = event.target.dataset.id;
    }


});




document
    .getElementById("closeCartDialog")
    .addEventListener("click", () => {
        document.getElementById("cartItemDialog").classList.add("hidden");
        document.body.style.overflow = "auto";
    });
async function loadDatabase() {
    const db = await idb.openDB("tailwind_store", 1, {
        upgrade(db, oldVersion, newVersion, transaction) {
            db.createObjectStore("products", {
                keyPath: "id",
                autoIncrement: true,
            });
            db.createObjectStore("sales", {
                keyPath: "id",
                autoIncrement: true,
            });
        },
    });

    return {
        db,
        getProducts: async () => await db.getAll("products"),
        addProduct: async (product) => await db.add("products", product),
        editProduct: async (product) =>
            await db.put("products", product.id, product),
        deleteProduct: async (product) =>
            await db.delete("products", product.id),
    };
}

function initApp() {
    const app = {
        db: null,
        time: null,
        firstTime: localStorage.getItem("first_time") === null,
        activeMenu: "pos",

        moneys: [2000, 5000, 10000, 20000, 50000, 100000],
        products: [],
        keyword: "",
        cart: [],
        cash: 0,
        change: 0,
        async initDatabase() {
            this.db = await loadDatabase();
            this.loadProducts();
        },
        async loadProducts() {
            this.products = await this.db.getProducts();
            console.log("products loaded", this.products);
        },

        setFirstTime(firstTime) {
            this.firstTime = firstTime;
            if (firstTime) {
                localStorage.removeItem("first_time");
            } else {
                localStorage.setItem("first_time", new Date().getTime());
            }
        },
        filteredProducts() {
            const rg = this.keyword ? new RegExp(this.keyword, "gi") : null;
            return this.products.filter((p) => !rg || p.name.match(rg));
        },
        addToCart(product) {

            const index = this.findCartIndex(product);
            if (index === -1) {
                this.cart.push({
                    productId: product.id,
                    image: product.image,
                    name: product.name,
                    price: product.price,
                    option: product.option,
                    qty: 1,
                });
            } else {
                this.cart[index].qty += 1;
            }
            this.beep();
            this.updateChange();
        },

        findCartIndex(product) {
            return this.cart.findIndex((p) => p.productId === product.id);
        },
        addQty(item, qty) {
            const index = this.cart.findIndex(
                (i) => i.productId === item.productId
            );
            if (index === -1) {
                return;
            }
            const afterAdd = item.qty + qty;
            if (afterAdd === 0) {
                this.cart.splice(index, 1);
                this.clearSound();
            } else {
                this.cart[index].qty = afterAdd;
                this.beep();
            }
            this.updateChange();
        },
        addCash(amount) {
            this.cash = (this.cash || 0) + amount;
            this.updateChange();
            this.beep();
        },
        getItemsCount() {
            return this.cart.reduce((count, item) => count + item.qty, 0);
        },
        updateChange() {
            this.change = this.cash - this.getTotalPrice();
        },
        updateCash(value) {
            this.cash = parseFloat(value.replace(/[^0-9]+/g, ""));
            this.updateChange();
        },
        getTotalPrice() {
            return this.cart.reduce(
                (total, item) => total + item.qty * item.price,
                0
            );
        },
        submitable() {
            return this.change >= 0 && this.cart.length > 0;
        },
        submit() {
            const time = new Date();
            this.isShowModalReceipt = true;
            this.receiptNo = `TWPOS-KS-${Math.round(time.getTime() / 1000)}`;
            this.receiptDate = this.dateFormat(time);
        },
        closeModalReceipt() {
            this.isShowModalReceipt = false;
        },
        dateFormat(date) {
            const formatter = new Intl.DateTimeFormat("id", {
                dateStyle: "short",
                timeStyle: "short",
            });
            return formatter.format(date);
        },
        numberFormat(number) {
            return (number || "")
                .toString()
                .replace(/^0|\./g, "")
                .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        },
        priceFormat(number) {
            return number ? `${this.numberFormat(number)} so'm` : `0 so'm`;
        },
        clear() {
            this.cash = 0;
            this.cart = [];
            this.receiptNo = null;
            this.receiptDate = null;
            this.updateChange();
            this.clearSound();
        },
        beep() {
            this.playSound("/pos/sound/beep-29.mp3");
        },
        clearSound() {
            this.playSound("/pos/sound/button-21.mp3");
        },
        playSound(src) {
            const sound = new Audio();
            sound.src = src;
            sound.play();
            sound.onended = () => delete sound;
        },
        getCart(){
            console.log(this.cart);
            return this.cart;
        }
    };

    return app;
}
// Add this to your existing JavaScript
const foodItems = document.querySelectorAll("#foodContent .bg-white");
const serviceItems = document.querySelectorAll(
    "#servicesContent .bg-white"
);
function addToCart(element) {
    const name = element.name;
    const price = element.price;
    const image = element.image;
    // Access Alpine.js data store
    const app = document.querySelector("[x-data]").__x.$data;
    if(element.type == 2){
        let index = app.findCartIndex(element);
        if(index == -1){
            document.getElementById('customDialogUstabtn').value = element.id;
            customDialogUsta.classList.remove("hidden");
        }
    }

    app.addToCart({
        id: element.id,
        name: name,
        price: price,
        image: image,
        option:element.option,
        qty: 1,
        user_id: user_id,
    });
}



// Add click handlers
foodItems.forEach((item) => {
    item.addEventListener("click", () => addToCart(item));
});

serviceItems.forEach((item) => {
    item.addEventListener("click", () => addToCart(item));
});
// Add this inside your existing script tag
const keyboard = document.getElementById("keyboard");
const keyboardInput = document.getElementById("keyboardInput");
let currentCartItem = null;

keyboard.addEventListener("click", (e) => {
    if (e.target.classList.contains("letter")) {
        if (e.target.textContent === ',') {
            if (!keyboardInput.value.includes(',')) {
                keyboardInput.value = keyboardInput.value.replace(/\s+/g, '') + ',';
            }
        } else {
            keyboardInput.value = (keyboardInput.value + e.target.textContent).replace(/\s+/g, '');
        }
    }

    if (e.target.classList.contains("return")) {
        if (currentCartItem && keyboardInput.value) {
            const app = document.querySelector("[x-data]").__x.$data;
            const cartItem = app.cart.find(item => item.productId === currentCartItem.productId);
            if (cartItem) {
                let qty = parseFloat(keyboardInput.value.replace(',', '.'));
                if(cartItem.option < qty){
                    qty = cartItem.option;
                    alert("Skladda "+qty+" ta qolgan");
                }

                cartItem.qty = qty;
                app.updateChange();
            }
            document.getElementById("cartItemDialog").classList.add("hidden");
            document.body.style.overflow = "auto";
            keyboardInput.value = "";
        }
    }
});




// Get all items from both food and services sections
const allItems = {
    food: Array.from(
        document.querySelectorAll("#foodContent .bg-white")
    ).map((item) => ({
        element: item,
        name: item.querySelector("h3").textContent,
        price: item.querySelector("p").textContent,
    })),
    services: Array.from(
        document.querySelectorAll("#servicesContent .bg-white")
    ).map((item) => ({
        element: item,
        name: item.querySelector("h3").textContent,
        price: item.querySelector("p").textContent,
    })),
};

// Add search functionality
/*const searchInput = document.querySelector('input[placeholder="Search"]');

searchInput.addEventListener("input", (e) => {
    const searchTerm = e.target.value.toLowerCase();

    // Search in both food and services
    Object.values(allItems).forEach((category) => {
        category.forEach((item) => {
            const matches =
                item.name.toLowerCase().includes(searchTerm) ||
                item.price.toLowerCase().includes(searchTerm);

            item.element.style.display = matches ? "block" : "none";
        });
    });
});*/

// Modify your existing cart item click handler
document.addEventListener("click", (e) => {
    if (e.target.matches(".text-sm, img, h5")) {
        const cartItem = e.target.closest(".select-none.mb-3");
        if (cartItem) {
            const dialog = document.getElementById("cartItemDialog");
            const img = cartItem.querySelector("img").src;
            const title = cartItem.querySelector("h5").textContent;
            const price = cartItem.querySelector("p").textContent;

            // Store current cart item reference
            const app = document.querySelector("[x-data]").__x.$data;
            currentCartItem = app.cart.find((item) => item.name === title);

            document.getElementById("dialogTitle").textContent = title;
            document.getElementById("dialogPrice").textContent = price;
            keyboardInput.value = "";

            dialog.classList.remove("hidden");
            document.body.style.overflow = "hidden";
        }
    }
});

const umumiynarx = document.getElementById('umumiynarx');
const tulov = document.getElementById('tulov');
// const chegirma = document.getElementById('chegirma');
const sotish = document.getElementById('sotish');
const submitqarz = document.getElementById('submitqarz');
const sotuvturi = document.getElementById('sotuvturi');
const qarzdordiv = document.getElementById('qarzdordiv');

submitqarz.addEventListener("click", () => {
    // Jadvalni tozalaymiz
    listsales.innerHTML = "";
    let narx = 0;
    sotuvturi.value='qarz';
    // Alpine.js ma'lumotlarini olamiz
    const app = document.querySelector("[x-data]").__x.$data;
    const cart = app.cart;

    // Jadval yaratamiz
    const table = document.createElement("table");
    table.style.width = "100%";
    table.style.borderCollapse = "collapse";

    // Jadval sarlavhalari
    const headers = ["#", "Nomi", "Narxi", "Soni","Umumiy narx"];
    const thead = document.createElement("thead");
    const headerRow = document.createElement("tr");

    headers.forEach(headerText => {
        const th = document.createElement("th");
        th.textContent = headerText;
        th.style.border = "1px solid #ddd";
        th.style.padding = "8px";
        th.style.textAlign = "left";
        headerRow.appendChild(th);
    });
    thead.appendChild(headerRow);
    table.appendChild(thead);

    // Jadval tanasi
    const tbody = document.createElement("tbody");

    cart.forEach(product => {
        const row = document.createElement("tr");

        // Har bir ustun uchun ma'lumot qo'shamiz
        const productIdCell = document.createElement("td");
        productIdCell.textContent = product.productId;
        productIdCell.style.border = "1px solid #ddd";
        productIdCell.style.padding = "8px";

        const nameCell = document.createElement("td");
        nameCell.textContent = product.name;
        nameCell.style.border = "1px solid #ddd";
        nameCell.style.padding = "8px";

        const priceCell = document.createElement("td");
        priceCell.textContent = `${product.price} so'm`;
        priceCell.style.border = "1px solid #ddd";
        priceCell.style.padding = "8px";

        const qtyCell = document.createElement("td");
        qtyCell.textContent = product.qty;
        qtyCell.style.border = "1px solid #ddd";
        qtyCell.style.padding = "8px";

        const qtyCnt = document.createElement("td");
        let p = product.qty * product.price;
        qtyCnt.textContent = p+" so'm";
        qtyCnt.style.border = "1px solid #ddd";
        qtyCnt.style.padding = "8px";
        narx += p;
        // Ustunlarni qatorga qo'shamiz
        row.appendChild(productIdCell);
        row.appendChild(nameCell);
        row.appendChild(priceCell);
        row.appendChild(qtyCell);
        row.appendChild(qtyCnt);

        // Qatorni jadval tanasiga qo'shamiz
        tbody.appendChild(row);
    });

    table.appendChild(tbody);

    // Jadvalni sahifaga qo'shamiz
    listsales.appendChild(table);
    umumiynarx.value = narx;
    tulov.value = narx;
    qarzdordiv.classList.remove('hidden');
    // Dialogni ko'rsatamiz
    customDialog.classList.remove("hidden");
});



// chegirma.addEventListener('change',()=>{
//     let narx = umumiynarx.value;
//     let chegnarx = chegirma.value;
//     if(chegnarx > narx){
//         chegirma.value = narx;
//         tulov.value = 0;
//     }
//     if(chegnarx <= narx){
//         tulov.value = narx - chegnarx;
//     }
// });

const qarzdor = document.getElementById('qarzdor');
const qarzdorname = document.getElementById('qarzdorname');
const qarzdorphone = document.getElementById('qarzdorphone');
const paydate = document.getElementById('paydate');

sotish.addEventListener('click',()=>{
    const selected = document.querySelector('input[name="paidtype"]:checked');
    if(!selected){
        alert('To`lov turini tanlang');

    }else{
        const app = document.querySelector("[x-data]").__x.$data;
        let data = {
            cart: app.cart,
            paidtype: selected.value,
            sotuvturi: sotuvturi.value,
            qarzdor_id: qarzdor.value,
            qarzdor_name: qarzdorname.value,
            qarzdor_phone: qarzdorphone.value,
            paydate: paydate.value
        };

        const payload = JSON.stringify(data);

        

        fetch('/cp/gen/saled', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: payload
        })
            .then(response => response.json())
            .then(data => {
                if(data.status == 'success'){
                    let sound = new Audio();
                    sound.src = '/pos/sound/sale.mp3';
                    sound.play();
                    sound.onended = () => delete sound;
                    setTimeout(() => {
                        console.log('2 soniyadan keyin sahifa yangilanmoqda...');
                        location.reload();
                    }, 1500);
                }
            });
    }


});

submitButton.addEventListener("click", () => {
    // Jadvalni tozalaymiz
    listsales.innerHTML = "";
    let narx = 0;
    sotuvturi.value = 'ustida';
    qarzdordiv.classList.add('hidden');
    // Alpine.js ma'lumotlarini olamiz
    const app = document.querySelector("[x-data]").__x.$data;
    const cart = app.cart;

    // Jadval yaratamiz
    const table = document.createElement("table");
    table.style.width = "100%";
    table.style.borderCollapse = "collapse";

    // Jadval sarlavhalari
    const headers = ["#", "Nomi", "Narxi", "Soni","Umumiy narx"];
    const thead = document.createElement("thead");
    const headerRow = document.createElement("tr");

    headers.forEach(headerText => {
        const th = document.createElement("th");
        th.textContent = headerText;
        th.style.border = "1px solid #ddd";
        th.style.padding = "8px";
        th.style.textAlign = "left";
        headerRow.appendChild(th);
    });
    thead.appendChild(headerRow);
    table.appendChild(thead);

    // Jadval tanasi
    const tbody = document.createElement("tbody");

    cart.forEach(product => {
        const row = document.createElement("tr");

        // Har bir ustun uchun ma'lumot qo'shamiz
        const productIdCell = document.createElement("td");
        productIdCell.textContent = product.productId;
        productIdCell.style.border = "1px solid #ddd";
        productIdCell.style.padding = "8px";

        const nameCell = document.createElement("td");
        nameCell.textContent = product.name;
        nameCell.style.border = "1px solid #ddd";
        nameCell.style.padding = "8px";

        const priceCell = document.createElement("td");
        priceCell.textContent = `${product.price} so'm`;
        priceCell.style.border = "1px solid #ddd";
        priceCell.style.padding = "8px";

        const qtyCell = document.createElement("td");
        qtyCell.textContent = product.qty;
        qtyCell.style.border = "1px solid #ddd";
        qtyCell.style.padding = "8px";

        const qtyCnt = document.createElement("td");
        let p = product.qty * product.price;
        qtyCnt.textContent = p+" so'm";
        qtyCnt.style.border = "1px solid #ddd";
        qtyCnt.style.padding = "8px";
        narx += p;
        // Ustunlarni qatorga qo'shamiz
        row.appendChild(productIdCell);
        row.appendChild(nameCell);
        row.appendChild(priceCell);
        row.appendChild(qtyCell);
        row.appendChild(qtyCnt);

        // Qatorni jadval tanasiga qo'shamiz
        tbody.appendChild(row);
    });

    table.appendChild(tbody);

    // Jadvalni sahifaga qo'shamiz
    listsales.appendChild(table);
    umumiynarx.value = narx;
    tulov.value = narx;

    // Dialogni ko'rsatamiz
    customDialog.classList.remove("hidden");
});


document.getElementById('printButton').addEventListener('click', function () {
    // Yangi oyna ochish
    const newWindow = window.open('', 'childWindow', 'width=800,height=600');

    // [x-data] dan ma'lumotlarni olish
    const app = document.querySelector("[x-data]").__x.$data;
    const data = app.cart;

    // Ma'lumotlarni JSON formatida tayyorlash
    const payload = JSON.stringify(data);

    // AJAX so'rov yuborish
    fetch('/cp/gen/print', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: payload
    })
        .then(response => response.text())
        .then(html => {
            // Serverdan kelgan javobni yangi oynada ochish
            newWindow.document.open();
            newWindow.document.write(html);
            newWindow.document.close();
        });
});
const closeDialogUsta = document.getElementById('closeDialogUsta');

closeDialogUsta.addEventListener('click',()=>{
    customDialogUsta.classList.add('hidden');
});
customDialogUstabtn.addEventListener('click',()=>{
    const selected = document.querySelector('input[name="user"]:checked');
    if(!selected){
        alert('Bu xizmatni kim bajarishini tanlang!');
    }else{
        customDialogUstabtn.classList.remove("hidden");
        const app = document.querySelector("[x-data]").__x.$data;
        let index = app.cart.findIndex((p) => p.productId === parseInt(customDialogUstabtn.value));
        app.cart[index].user_id = selected.value;
        customDialogUsta.classList.add('hidden');
        selected.checked = false;
    }

});

const sotishandprint = document.getElementById('sotishandprint');
sotishandprint.addEventListener('click',()=>{
    const selected = document.querySelector('input[name="paidtype"]:checked');
    if(!selected){
        alert('To`lov turini tanlang');

    }else{
        const newWindow = window.open('', 'childWindow', 'width=800,height=600');

        const app = document.querySelector("[x-data]").__x.$data;
        let data = {
            cart: app.cart,
            paidtype: selected.value,
            sotuvturi:sotuvturi.value,
            qarzdor_id: qarzdor.value,
            qarzdor_name: qarzdorname.value,
            qarzdor_phone: qarzdorphone.value,
            paydate: paydate.value
        };
        const payload = JSON.stringify(data);
        fetch('/cp/gen/saled', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: payload
        })
            .then(response => response.json())
            .then(data => {
                if(data.status == 'success'){

                    fetch('/cp/gen/saledprint?id='+data.sale_id, {
                        method: 'GET',
                    })
                        .then(response => response.text())
                        .then(html => {
                            if(html != -1){
                                let sound = new Audio();
                                sound.src = '/pos/sound/sale.mp3';
                                sound.play();
                                sound.onended = () => delete sound;
                                setTimeout(() => {
                                    console.log('2 soniyadan keyin sahifa yangilanmoqda...');
                                }, 1500);
                                newWindow.document.open();
                                newWindow.document.write(html);
                                newWindow.document.close();
                                location.reload();

                            }
                        });

                }
            });
    }


});