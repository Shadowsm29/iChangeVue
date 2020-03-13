import store from "../store/index"

export function handleErrorResponse(err, next) {
    if (err.response.status && err.response.status === 422) {
        store.commit("messages/addValidationError", err.response);
    } else if (err.response.status && err.response.status === 401) {
        next({name: "unauthorized"});
    } else {
        alert("Something went wrong. Please try again.");
        next(false);
    }
}

export function handleSuccessResponse(message) {
    store.commit("messages/addSuccessMessage", message);
}