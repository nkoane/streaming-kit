<script lang="ts">
    import { onMount } from 'svelte';

    let messages: string[] = [];

    onMount(() => {
        try {
            const uri = '/api/stream?duration=10';

            const ev = new EventSource(uri, {
                withCredentials: true
            });

            const main = document.getElementById('main');

            ev.addEventListener('open', (event) => {
                console.log('event-source:open');
            });

            ev.addEventListener('message', (event) => {
                messages = [...messages, event.data];
            });

            ev.addEventListener('ping', (event) => {
                const { time, diff, micro, duration, counter } = JSON.parse(event.data);
                messages = [
                    ...messages,
                    `ping: ${time}, counter: ${counter}, duration: ${duration} , micro: ${micro}, diff: ${diff}`
                ];

                main?.scrollTo(0, main.scrollHeight);
            });

            ev.onerror = (error) => {
                console.error('event-source:error', error);
                ev.close();
            };
        } catch (error) {
            console.error('page:error', error);
        }
    });
</script>

<main id="main" class="overflow-y-auto pb-10">
    {#each messages as message, index (message)}
        <p class="bg-white text-black even:text-white even:bg-black even:p-4">{@html message}</p>
        {#if index === messages.length - 1}
            <p>&hellip;</p>
        {/if}
    {/each}
</main>
