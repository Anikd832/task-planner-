import { useRouter } from "vue-router";
import { useDatatableStore } from "../store/useDatatableStore";
const datatableStore = useDatatableStore();
const router = useRouter();
export function useCommon() {
  function confirm(msg = "Are you sure?") {
    return confirm(msg) ? true : false;
  }

  function isLoading(loading) {
    return loading ? "loader" : "";
  }

  function formatYmd(date) {
    return moment(date, "DD/MM/YYYY").format("YYYY-MM-DD");
  }

  function dateFormat(date, from = "YYYY-MM-DD", to = "DD/MM/YYYY") {
    return moment(date, from).format(to);
  }

  // check has role
  function hasRole(...role) {
    return window.App.user.role
      .split(":")
      .some((userRole) => role.indexOf(userRole) > -1);
  }

  // scroll to top
  function scrollTop() {
    $("html, body").animate({ scrollTop: 0 }, "slow");
  }

  /* Decode Url Query String & convert into object */
  function getUrlParams(search) {
    if (search == null || search == "" || search == undefined) {
      search = window.location.search;
      if (search == "") return {};
    }

    let hashes = search.slice(search.indexOf("?") + 1).split("&");
    return hashes.reduce((params, hash) => {
      let [key, val] = hash.split("=");
      return Object.assign(params, {
        [key]: decodeURIComponent(val),
      });
    }, {});
  }

  function removeUrlQueryParams(params) {
    const url = new URL(location);
    for (let i = 0; i <= params.length; i++) {
      url.searchParams.delete(params[i]);
    }
    history.replaceState(null, null, url);
  }

  /* Extend or add some data to an existing url params*/
  function appendToUrlQueryParams(delimeter, key, value) {
    const url = new URL(location);
    let result = value;
    url.searchParams.forEach(function (item, index) {
      if (index == key) {
        result = item + delimeter + value;
      }
    });
    url.searchParams.delete(key);
    url.searchParams.append(key, result);
    history.replaceState(null, null, url);
  }

  /* Build Url Query String*/
  function buildURLQuery(params = {}, searchQuery = null) {
    let qParams;
    if (searchQuery) {
      if (searchQuery === true) {
        searchQuery = window.location.search;
      }

      qParams = { ...getUrlParams(searchQuery), ...params };
    } else {
      qParams = params;
    }

    const esc = encodeURIComponent;
    const query = Object.keys(qParams)
      .map((key) =>
        qParams[key] === "undefined" ||
        qParams[key] == undefined ||
        qParams[key] === null
          ? esc(key)
          : `${esc(key)}=${esc(qParams[key])}`
      )
      .join("&");
    return query;
  }

  /*Get plain text url search query string */
  function getURLQueryString() {
    let queryParam = buildURLQuery(getUrlParams());
    return queryParam ? "?" + queryParam : "";
  }

  function headers(...params) {
    let headers = [];
    for (let item of params) {
      if (item.toLowerCase() == "action") {
        headers.push({
          title: item,
          key: item.split(" ").join("_").toLowerCase(),
          sortable: false,
        });
      } else {
        headers.push({
          title: item,
          key: item.split(" ").join("_").toLowerCase(),
        });
      }
    }
    return headers;
    return [
      { title: "Title", key: "title" },
      { title: "Description", key: "description" },
      { title: "Start Time", key: "start_time" },
      { title: "Start Date", key: "start_date" },
      { title: "Status", key: "status" },
      { title: "Action", key: "action", sortable: false },
    ];
  }

  // common delete request
  async function deleteData(url, params = {}) {
    return await axios
      .delete(url, params)
      .then((response) => {
        flash(response.data.message);
        return true;
      })
      .catch((error) => {
        flash(error.response.data.message, "danger");
        return false;
      });
  }

  function initFilters() {
    let queryParams = getUrlParams();
    for (let key in queryParams) {
      this[filterable][key] = queryParams[key];
      if (key == "q") {
        $store.dispatch("updateSearchStr", {
          search_str: queryParams[key],
        });
      }
    }
  }

  function handleError(errors) {
    let errorMessage = "";
    const errs = [];
    for (const key of Object.keys(errors)) {
      const singleError = errors[key];
      for (const k of Object.keys(singleError)) {
        errs.push(singleError[k]);
        errorMessage += singleError[k] + " ";
      }
    }
    return { message: errorMessage, errors: errs };
  }

  function isEmptyObject(object = {}) {
    return Object.keys(object).length === 0 ? true : false;
  }

  function pageChange(page, limit) {
    console.log(page);
    console.log(limit);
    history.pushState(
      null,
      null,
      `?${buildURLQuery({ limit: limit || 10, page: page || 1 }, true)}`
    );
    datatableStore.$state.reloadDatatable = true;
  }

  function applySearch(str) {
    history.pushState(
      null,
      null,
      `?${buildURLQuery({ q: str, page: 1 }, true)}`
    );
    datatableStore.$state.reloadDatatable = true;
  }

  function changeOrderBy(sortBy = []) {
    console.log(sortBy);
    if (sortBy.length <= 0) {
      removeUrlQueryParams(["order", "direction"]);
      return;
    }
    for (let item of sortBy) {
      let order = item.key;
      let direction = item.order;
      history.pushState(
        null,
        null,
        `?${buildURLQuery({ order, direction }, true)}`
      );
    }
    datatableStore.$state.reloadDatatable = true;
  }

  function filterBy(column, event = null, value = null) {
    // column is database field name, use for filter by
    // value will be taken from event

    // console.log(column); console.log(event); return
    let key = column;
    var filter = {};
    if (value != null) {
      filter[column] = value;
    } else {
      filter[column] = event;
    }
    history.pushState(null, null, `?${buildURLQuery(filter, true)}`);
    datatableStore.$state.reloadDatatable = true;
  }

  function setCookie(name, value, days) {
    var expires = "";
    if (days) {
      var date = new Date();
      date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
      expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
  }

  function uuid() {
    function s4() {
      return Math.floor((1 + Math.random()) * 0x10000)
        .toString(16)
        .substring(1);
    }
    return (
      s4() +
      s4() +
      "-" +
      s4() +
      "-" +
      s4() +
      "-" +
      s4() +
      "-" +
      s4() +
      s4() +
      s4()
    );
  }

  return {
    uuid,
    handleError,
    isEmptyObject,
    getUrlParams,
    getURLQueryString,
    filterBy,
    changeOrderBy,
    applySearch,
    pageChange,
    headers,
  };
}
