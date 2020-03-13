export const state = {
    messages: [
        // { id: 0, message: "First error", status: "new" }, 
        // { id: 1, message: "Second error", status: "new" },
    ],
    messageCount: 1,
}

export const getters = {
    messages: state => state.messages,
}

export const mutations = {
    addValidationError(state, { data: { errors } }) {
        for(let key in errors) {
            state.messages = [
                ...state.messages,
                { id: state.messageCount++, text: errors[key][0], status: "new", type: "error" }
            ];
        }
    },
    addSuccessMessage(state, text) {
        state.messages = [
            ...state.messages,
            { id: state.messageCount++, text: text, status: "new", type: "success" }
        ];
    },
    addErrorMessage(state, text) {
        state.messages = [
            ...state.messages,
            { id: state.messageCount++, text: text, status: "new", type: "error" }
        ];
    }
}