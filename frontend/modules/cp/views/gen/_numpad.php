<div id="cartItemDialog" class="hidden">
    <div class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm transition-all z-50">
        <div class="fixed flex items-center justify-center inset-0 z-50">
            <div class="w-96 rounded-lg border bg-white shadow-lg duration-200">
                <!-- Rest of dialog content -->
                <div class="flex flex-col space-y-3.5 px-2">
                    <div id="container">
                        <div class="flex justify-end">
                            <button id="closeCartDialog" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-red-500 text-white hover:bg-blue-600 h-10 px-4 py-2">
                                &times;
                            </button>
                        </div>
                        <h3 id="dialogTitle" class="text-2xl font-semibold leading-none tracking-tight pb-2"></h3>
                        <p id="dialogPrice" class="text-sm text-gray-500 pb-3"></p>
                        <input type="text" id="keyboardInput" class="w-full border rounded p-2 mb-3" readonly/>
                        <ul id="keyboard">
                            <li class="letter">1</li>
                            <li class="letter">2</li>
                            <li class="letter">3</li>
                            <li class="letter clearl">4</li>
                            <li class="letter">5</li>
                            <li class="letter">6</li>
                            <li class="letter clearl">7</li>
                            <li class="letter">8</li>
                            <li class="letter">9</li>
                            <li class="letter clearl">0</li>
                            <li class="letter clearl flex items-center justify-center">,</li>
                            <li class="return">OK</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>