export default async function Query(endpoint: string) {
    const base = typeof location !== 'undefined' ? location.origin : 'http://localhost';
    const path = endpoint.startsWith('http://') || endpoint.startsWith('https://') || endpoint.startsWith('/api/')
        ? endpoint
        : `/api/${endpoint.replace(/^\/+/, '')}`;

    // Relative paths such as /api/board are valid once a base is supplied.
    // URL.canParse rejects them when it is called with the path alone.
    if (!URL.canParse(path, base)) {
        throw new Error(`Invalid URL: ${path}`);
    }

    const requestUrl = new URL(path, base).toString();
    const response = await fetch(requestUrl, {
        headers: { Accept: 'application/json' },
    });

    if (!response.ok) {
        throw new Error(String(response.status));
    }

    return response.json();
}
