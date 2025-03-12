<section class="flex h-full w-full flex-col p-2">
    <header class="flex flex-col items-start justify-start pb-4">
        <input
            type="file"
            id="comprobantes"
            name="comprobantes[]"
            accept="image/png, image/jpeg, image/jpg"
            multiple
            capture="environment"
            class="hidden"
            value="{{ old('comprobantes') }}"
        />
        <button
            id="button"
            type="button"
            class="w-full rounded-lg bg-red-800 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-red-900 focus:outline-none focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 sm:w-auto"
        >
            <x-heroicon-o-camera class="-mt-1 inline-block h-5 w-5" />
            Subir
        </button>
    </header>

    {{-- <h1 class="pb-3 pt-2 font-semibold text-gray-900 text-sm">Evidencia a subir:</h1> --}}

    <ul id="gallery" class="-m-1 flex flex-1 flex-wrap">
        <li id="empty" class="flex h-full w-full flex-col items-center justify-center text-center">
            <img class="mx-auto w-32" src="/assets/img/upload-files.png" alt="no data" />
            <span class="text-small mt-2 text-gray-500">Puedes subir un máximo de 5 archivos</span>
            <span class="text-small mt-2 text-gray-500">(img, png, jpeg, jpg - max. 10MB)</span>
        </li>
    </ul>
</section>

<template id="image-template">
    <li class="xl:w-1/8 block w-1/2 p-1 sm:w-1/3 md:w-1/4 lg:w-1/6">
        <article
            tabindex="0"
            class="hasImage focus:shadow-outline group relative h-full w-full cursor-pointer rounded-md bg-gray-100 text-transparent shadow-sm hover:text-white focus:outline-none"
        >
            <img alt="upload preview" class="img-preview sticky h-full w-full rounded-md bg-fixed object-cover" />

            <section class="absolute top-0 z-20 flex h-full w-full flex-col break-words rounded-md px-3 py-2 text-xs">
                <h1 class="flex-1"></h1>
                <div class="flex">
                    <span class="p-1">
                        <i>
                            <svg
                                class="pt- ml-auto h-4 w-4 fill-current"
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M5 8.5c0-.828.672-1.5 1.5-1.5s1.5.672 1.5 1.5c0 .829-.672 1.5-1.5 1.5s-1.5-.671-1.5-1.5zm9 .5l-2.519 4-2.481-1.96-4 5.96h14l-5-8zm8-4v14h-20v-14h20zm2-2h-24v18h24v-18z"
                                />
                            </svg>
                        </i>
                    </span>

                    <p class="size p-1 text-xs"></p>
                    <button class="delete ml-auto rounded-md p-1 hover:bg-gray-300 focus:outline-none">
                        <svg
                            class="pointer-events-none ml-auto h-4 w-4 fill-current"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                        >
                            <path
                                class="pointer-events-none"
                                d="M3 6l3 18h12l3-18h-18zm19-4v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.316c0 .901.73 2 1.631 2h5.711z"
                            />
                        </svg>
                    </button>
                </div>
            </section>
        </article>
    </li>
</template>

<script>
    const imageTempl = document.getElementById('image-template');
    const empty = document.getElementById('empty');

    let FILES = {};

    function addFile(target, file) {
        const objectURL = URL.createObjectURL(file);
        const clone = imageTempl.content.cloneNode(true);
        clone.querySelector('h1').textContent = file.name;
        clone.querySelector('li').id = objectURL;
        clone.querySelector('.delete').dataset.target = objectURL;
        clone.querySelector('.size').textContent =
            file.size > 1024
                ? file.size > 1048576
                    ? Math.round(file.size / 1048576) + 'mb'
                    : Math.round(file.size / 1024) + 'kb'
                : file.size + 'b';

        Object.assign(clone.querySelector('img'), {
            src: objectURL,
            alt: file.name,
        });
        empty.classList.add('hidden');
        target.prepend(clone);
        FILES[objectURL] = file;
    }

    const gallery = document.getElementById('gallery');
    const overlay = document.getElementById('overlay');
    const hidden = document.getElementById('comprobantes');
    document.getElementById('button').onclick = () => hidden.click();
    hidden.onchange = (e) => {
        for (const file of e.target.files) {
            const isImage = file.type.match('image.png|image.jpeg|image.jpg');
            if (!isImage) {
                noty('Solo se permiten imágenes en formato PNG, JPEG o JPG', 'error');
                return;
            }
            addFile(gallery, file);
        }
    };

    // const hasFiles = ({ dataTransfer: { types = [] } }) => types.indexOf('Files') > -1;

    // let counter = 0;

    // function dropHandler(ev) {
    //     ev.preventDefault();
    //     for (const file of ev.dataTransfer.files) {
    //         addFile(gallery, file);
    //         overlay.classList.remove('draggedover');
    //         counter = 0;
    //     }
    // }

    // function dragEnterHandler(e) {
    //     e.preventDefault();
    //     if (!hasFiles(e)) {
    //         return;
    //     }
    //     ++counter && overlay.classList.add('draggedover');
    // }

    // function dragLeaveHandler(e) {
    //     1 > --counter && overlay.classList.remove('draggedover');
    // }

    // function dragOverHandler(e) {
    //     if (hasFiles(e)) {
    //         e.preventDefault();
    //     }
    // }

    gallery.onclick = ({ target }) => {
        if (target.classList.contains('delete')) {
            const ou = target.dataset.target;
            document.getElementById(ou).remove(ou);
            gallery.children.length === 1 && empty.classList.remove('hidden');
            delete FILES[ou];
        }
    };
</script>

<style>
    .hasImage:hover section {
        background-color: rgba(5, 5, 5, 0.4);
    }
    .hasImage:hover button:hover {
        background: rgba(5, 5, 5, 0.45);
    }

    /* #overlay p,
    i {
        opacity: 0;
    }

    #overlay.draggedover {
        background-color: rgba(255, 255, 255, 0.7);
    }
    #overlay.draggedover p,
    #overlay.draggedover i {
        opacity: 1;
    } */

    .group:hover .group-hover\:text-red-800 {
        color: #dc2626;
    }
</style>
