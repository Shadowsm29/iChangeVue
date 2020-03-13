
import * as handler from "../response-handler"
import Axios from "axios";

export const state = {
    users: [],
    roles: [],
}

export const getters = {
    users: state => state.users,
    roles: state => state.roles,
}

export const mutations = {
    setUsers(state, users) {
        state.users = users;
    },
    setRoles(state, roles) {
        state.roles = roles;
    }
}

export const actions = {
    fetchUsers({ commit }) {
        return new Promise((resolve, reject) => {
            Axios.get("/api/user-list")
                .then(({ data }) => {
                    commit("setUsers", data);
                    resolve(data)
                })
                .catch((err) => {
                    handler.handleErrorResponse(err.response, commit);
                    reject(err)
                });
        })
    },
    fetchRoles({ commit }) {
        return new Promise((resolve, reject) => {
            Axios.get("/api/roles")
                .then(({ data }) => {
                    commit("setRoles", data);
                    resolve(data)
                })
                .catch((err) => {
                    handler.handleErrorResponse(err.response, commit);
                    reject(err)
                });
        })
    }
}