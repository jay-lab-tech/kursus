/**
 * API Utility Functions with proper error handling
 */

const API_BASE = '/api';

/**
 * Safe API call with error handling
 */
async function apiCall(endpoint, options = {}) {
    const defaultOptions = {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    };

    // Add token if exists
    const token = localStorage.getItem('token');
    if (token) {
        defaultOptions.headers['Authorization'] = `Bearer ${token}`;
    }

    const finalOptions = {
        ...defaultOptions,
        ...options,
        headers: {
            ...defaultOptions.headers,
            ...options.headers
        }
    };

    try {
        const response = await fetch(`${API_BASE}${endpoint}`, finalOptions);

        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            // Not JSON response - likely HTML error page
            console.error('Error: Server returned non-JSON response');
            console.error('Status:', response.status);
            const text = await response.text();
            console.error('Response:', text.substring(0, 200));
            
            throw new Error(`Server returned ${response.status} with non-JSON response`);
        }

        const data = await response.json();

        // Handle API error responses
        if (!response.ok) {
            throw new Error(data.message || `HTTP Error ${response.status}`);
        }

        return data;

    } catch (error) {
        console.error('API Error:', error);
        throw error;
    }
}

/**
 * GET request
 */
function apiGet(endpoint) {
    return apiCall(endpoint, {
        method: 'GET'
    });
}

/**
 * POST request
 */
function apiPost(endpoint, data) {
    return apiCall(endpoint, {
        method: 'POST',
        body: JSON.stringify(data)
    });
}

/**
 * PUT request
 */
function apiPut(endpoint, data) {
    return apiCall(endpoint, {
        method: 'PUT',
        body: JSON.stringify(data)
    });
}

/**
 * DELETE request
 */
function apiDelete(endpoint) {
    return apiCall(endpoint, {
        method: 'DELETE'
    });
}

/**
 * Get available kelas
 */
async function getAvailableKelas(search = '') {
    try {
        const url = search ? `/kelas/available?search=${encodeURIComponent(search)}` : '/kelas/available';
        const data = await apiGet(url);
        return data.data || [];
    } catch (error) {
        console.error('Error fetching available kelas:', error);
        throw error;
    }
}

/**
 * Enroll mahasiswa in kelas
 */
async function enrollKelas(userId, kelasId) {
    try {
        const response = await apiPost(`/mahasiswa/${userId}/kelas/${kelasId}/enroll`, {});
        return response;
    } catch (error) {
        console.error('Error enrolling kelas:', error);
        throw error;
    }
}

/**
 * Unenroll mahasiswa from kelas
 */
async function unenrollKelas(userId, kelasId) {
    try {
        const response = await apiDelete(`/mahasiswa/${userId}/kelas/${kelasId}/unenroll`);
        return response;
    } catch (error) {
        console.error('Error unenrolling kelas:', error);
        throw error;
    }
}

/**
 * Get user enrolled kelas
 */
async function getUserEnrolledKelas(userId) {
    try {
        const data = await apiGet(`/mahasiswa/${userId}/kelas`);
        return data.data || [];
    } catch (error) {
        console.error('Error fetching enrolled kelas:', error);
        throw error;
    }
}
