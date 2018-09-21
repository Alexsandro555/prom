import * as actions from './actions'
import mutations from './mutations'
import cart from '../../../../Modules/Cart/Resources/assets/js/store/cart.js'
import auth from '../components/auth/store/state'
import sliderFullPage from './modules/slider-full-page/state'
import initializer from './modules/initializer'
import product from '../../../../Modules/Catalog/Resources/assets/js/components/product/store/states'
import group from '../../../../Modules/Catalog/Resources/assets/js/vuex/group/store'

export default function() {
    return {
       modules: {
           cart,
           auth,
           sliderFullPage,
           initializer,
           product,
           group
       },
    }
}