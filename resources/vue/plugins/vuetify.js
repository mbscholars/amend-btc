import Vue from 'vue';
import Vuetify from 'vuetify/lib';
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify);

export default new Vuetify({
	theme:{
		themes: {
			light: {
				primary: "#009688",
				secondary: "#000000",
				accent: "#a2ff00"
			}
		}
	}
});
