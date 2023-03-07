<script>
    import '../app.postcss';
</script>

<main class="bg-white p-8 mx-auto w-10/12 rounded-md shadow-md box">
    <header class="border-b-2 pb-4 mb-4"><h1>STREAM</h1></header>
    <slot />
</main>

<style>
    :global(html) {
        scroll-behavior: smooth;
        scroll-snap-type: mandatory;
    }

    :global(body) {
        background-color: #eaebeb;
        margin-top: 10rem;
    }
</style>
