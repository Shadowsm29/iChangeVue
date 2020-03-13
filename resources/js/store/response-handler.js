export function handleErrorResponse(err, commit) {
    if (err.status === 422) {
        commit("messages/addValidationError", err, { root: true });
    } else {
        commit("messages/addErrorMessage", "Something went wrong. Please try again.", { root: true });
    }
}

export function handleSuccessResponse(message, commit) {
    commit("messages/addSuccessMessage", message, { root: true });
}