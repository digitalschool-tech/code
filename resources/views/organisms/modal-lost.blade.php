<!-- Modal container -->
<div class="fixed z-10 inset-0 overflow-y-auto hidden" id="modal-lost" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- Modal dialog box -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <!-- Close button -->
            <div class="h-8 w-8 rounded-full bg-white-900 absolute -top-2 -right-2 flex justify-center items-center">
                @include("atoms.x")
            </div>

            <!-- Modal title -->
            <div class="bg-red-500 px-4 py-2 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-white" id="modal-title">
                    Sorry, You Lost!
                </h2>
            </div>

            <!-- Modal content -->
            <div class="p-4 bg-white">
                <p class="text-lg text-gray-700">
                    Oh no! You have lost this level. But don't worry, you can always try again and do better next time.
                </p>
                <p class="text-lg text-gray-700 mt-4">
                    Keep trying, keep practicing and you will surely succeed.
                </p>
                <img src="https://picsum.photos/400/200" alt="Retry" class="mt-6 mx-auto rounded-lg shadow-lg">
                <div class="mt-6">
                    <button type="button"
                            class="py-2 px-4 bg-red-500 hover:bg-red-600 text-white font-bold rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                        Retry
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

