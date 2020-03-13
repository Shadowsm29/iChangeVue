import axios from "axios";
import * as handler from "../response-handler"

export const state = {
    circles: null,
    superCircles: null,
    justifications: null,
}

export const getters = {
    circles: state => state.circles,
    superCircles: state => state.superCircles,
    justifications: state => state.justifications,
}

export const mutations = {
    setCircles(state, circles) {
        state.circles = circles;
    },
    setSuperCircles(state, superCircles) {
        state.superCircles = superCircles;
    },
    setJustifications(state, justifications) {
        state.justifications = justifications;
    },
    updateCircle({ circles }, circleUpdated) {
        const circleOld = circles.filter(c => c.id === circleUpdated.id)[0];
        circles.splice(circles.indexOf(circleOld), 1, circleUpdated);
    },
    updateSuperCircle({ superCircles }, superCircleUpdated) {
        const superCircleOld = superCircles.filter(c => c.id === superCircleUpdated.id)[0];
        superCircles.splice(superCircles.indexOf(superCircleOld), 1, superCircleUpdated);
    },
    updateJustification({ justifications }, justificationUpdated) {
        const justificationOld = justifications.filter(c => c.id === justificationUpdated.id)[0];
        justifications.splice(justifications.indexOf(justificationOld), 1, justificationUpdated);
    },
    addNewCircle(state, newCircle) {
        state.circles = [
            newCircle,
            ...state.circles
        ]
    },
    addNewSuperCircle( state, newSuperCircle) {
        state.superCircles = [
            newSuperCircle,
            ...state.superCircles
        ]
    },
    addNewJustification(state, newJustification) {
        state.justifications = [
            newJustification,
            ...state.justifications
        ]
    },
    deleteCircle(state, circleId) {
        const circleToDelete = state.circles.filter(c => c.id === circleId)[0];
        state.circles.splice(state.circles.indexOf(circleToDelete), 1);
    },
    deleteSuperCircle( state, superCircleId) {
        const superCircleToDelete = state.superCircles.filter(c => c.id === superCircleId)[0];
        state.superCircles.splice(state.superCircles.indexOf(superCircleToDelete), 1);
    },
    deleteJustification(state, justificationId) {
        const justificationToDelete = state.justifications.filter(c => c.id === justificationId)[0];
        state.justifications.splice(state.justifications.indexOf(justificationToDelete), 1);
    },
}

export const actions = {
    fetchCircles({ commit }) {
        return new Promise((resolve, reject) => {
            axios.get("/api/circles")
                .then(({ data }) => {
                    commit("setCircles", data);
                    resolve(data)
                }, error => {
                    reject(error);
                });
        })
    },

    fetchSuperCircles({ commit }) {
        return new Promise((resolve, reject) => {
            axios.get("/api/super-circles")
                .then(({ data }) => {
                    commit("setSuperCircles", data);
                    resolve(data)
                }, error => {
                    reject(error);
                });
        })
    },

    fetchJustifications({ commit }) {
        return new Promise((resolve, reject) => {
            axios.get("/api/justifications")
                .then(({ data }) => {
                    commit("setJustifications", data);
                    resolve(data)
                }, error => {
                    reject(error);
                });
        })
    },

    fetchAll({ dispatch }) {
        let circles = dispatch("fetchCircles");
        let superCircles = dispatch("fetchSuperCircles");
        let justifications = dispatch("fetchJustifications");

        return Promise.all([circles, superCircles, justifications]);
    },

    updateCircle({ commit }, { id, name, super_circle_id }) {
        return new Promise((resolve, reject) => {
            axios.post(`/api/circles/${id}/update`, { name, super_circle_id })
                .then((res) => {
                    commit("updateCircle", res.data);
                    handler.handleSuccessResponse("Circle updated successfully", commit);
                    resolve(res);
                }).catch((err) => {
                    handler.handleErrorResponse(err.response, commit);
                    reject(err.response);
                });
        })
    },

    updateSuperCircle({ commit }, { id, name }) {
        return new Promise((resolve, reject) => {
            axios.post(`/api/super-circles/${id}/update`, { name })
                .then((res) => {
                    commit("updateSuperCircle", res.data);
                    handler.handleSuccessResponse("Super circle updated successfully", commit);
                    resolve(res);
                }).catch((err) => {
                    handler.handleErrorResponse(err.response, commit);
                    reject(err.response);
                });
        })
    },

    updateJustification({ commit }, { id, name }) {
        return new Promise((resolve, reject) => {
            axios.post(`/api/justifications/${id}/update`, { name })
                .then((res) => {
                    commit("updateJustification", res.data);
                    handler.handleSuccessResponse("Justification updated successfully", commit);
                    resolve(res);
                }).catch((err) => {
                    handler.handleErrorResponse(err.response, commit);
                    reject(err.response);
                });
        })
    },

    addNewCircle({ commit }, { name, super_circle_id }) {
        return new Promise((resolve, reject) => {
            axios.post(`/api/circles/new`, { name, super_circle_id })
                .then((res) => {
                    commit("addNewCircle", res.data);
                    handler.handleSuccessResponse("Circle created successfully", commit);
                    resolve(res);
                }).catch(err => {
                    handler.handleErrorResponse(err.response, commit);
                    reject(err.response);
                });
        })
    },

    addNewSuperCircle({ commit }, { name }) {
        return new Promise((resolve, reject) => {
            axios.post(`/api/super-circles/new`, { name })
                .then((res) => {
                    commit("addNewSuperCircle", res.data);
                    handler.handleSuccessResponse("Super circle created successfully", commit);
                    resolve(res);
                }).catch(err => {
                    handler.handleErrorResponse(err.response, commit);
                    reject(err.response);
                });
        })
    },

    addNewJustification({ commit }, { name }) {
        return new Promise((resolve, reject) => {
            axios.post(`/api/justifications/new`, { name })
                .then((res) => {
                    commit("addNewJustification", res.data);
                    handler.handleSuccessResponse("Justification created successfully", commit);
                    resolve(res);
                }).catch(err => {
                    handler.handleErrorResponse(err.response, commit);
                    reject(err.response);
                });
        })
    },

    deleteCircle({ commit }, { id }) {
        return new Promise((resolve, reject) => {
            axios.delete(`/api/circles/${id}/delete`)
                .then((res) => {
                    commit("deleteCircle", res.data);
                    handler.handleSuccessResponse("Circle deleted successfully", commit);
                    resolve(res);
                }).catch(err => {
                    handler.handleErrorResponse(err.response, commit);
                    reject(err.response);
                });
        })
    },

    deleteSuperCircle({ commit }, { id }) {
        return new Promise((resolve, reject) => {
            axios.delete(`/api/super-circles/${id}/delete`)
                .then((res) => {
                    commit("deleteSuperCircle", res.data);
                    handler.handleSuccessResponse("Super circle deleted successfully", commit);
                    resolve(res);
                }).catch(err => {
                    handler.handleErrorResponse(err.response, commit);
                    reject(err.response);
                });
        })
    },

    deleteJustification({ commit }, { id }) {
        return new Promise((resolve, reject) => {
            axios.delete(`/api/justifications/${id}/delete`)
                .then((res) => {
                    commit("deleteJustification", res.data);
                    handler.handleSuccessResponse("Justification deleted successfully", commit);
                    resolve(res);
                }).catch(err => {
                    handler.handleErrorResponse(err.response, commit);
                    reject(err.response);
                });
        })
    },

}



