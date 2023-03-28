
// Add a request interceptor
axios.interceptors.request.use(function (config) {
    // Do something before request is sent
    document.body.classList.add('loading-indicator');

    return config;
}, function (error) {
    // Do something with request error
    return Promise.reject(error);
});

// Add a response interceptor
axios.interceptors.response.use(function (response) {
    // Any status code that lie within the range of 2xx cause this function to trigger
    // Do something with response data
    setTimeout(function(){

    document.body.classList.remove('loading-indicator');
    },1000);
    return response;
}, function (error) {
    document.body.classList.remove('loading-indicator');
    // Any status codes that falls outside the range of 2xx cause this function to trigger
    // Do something with response error
    
    return Promise.reject(error);
});