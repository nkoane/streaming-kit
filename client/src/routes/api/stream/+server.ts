import type { RequestHandler } from './$types';
import { json } from '@sveltejs/kit';

export const GET: RequestHandler = async () => {
    try {
        const streamUrl = 'http://localhost:8000';

        const response = await fetch(streamUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            const err = await response.json();
            throw new Error('OpenAI API Error', err);
        }

        return new Response(response.body, {
            headers: {
                'content-type': 'text/event-stream'
            }
        });
    } catch (err) {
        console.error(err);
        return json({ error: 'There was an error processing your request' }, { status: 500 });
    }
};
