const ADD_CART = {
    ADD_CART : (state, data) => {
        state.count = data.count;
        state.total = data.total;
    }
}

export { ADD_CART };
