import Http from "../http"
import cookies from "./cookies"

export default new Http({
	headers: {
		"X-CSRFToken": () => cookies.get("csrftoken")
	}
})