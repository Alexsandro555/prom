import {ACTIONS} from "../../../../../../../resources/assets/js/constants";
import {groupApi} from "../../api/group.js"

export default {
    [ACTIONS.UPDATE_ITEM]: ({commit}, objField) => {
        commit('SET_ITEM',objField)
    },
    [ACTIONS.SAVE_DATA]: ({state}) => {
        groupApi.save(state.items).then(response => {

        }).catch(err => {})
    }
}