import Errors from "./errors.js";

class Form {
  /**
   * Create a new Form instance.
   *
   * @param {object} data
   */
  constructor(data) {


    this.originalData = data;

    for (let field in data) {
      this[field] = data[field];
    }

    this.errors = new Errors();
  }

  /**
   * Fetch all relevant data for the form.
   */
  data() {
    let data = {};

    for (let property in this.originalData) {
      data[property] = this[property];
    }

    return data;
  }

  /**
   * Reset the form fields.
   */
  reset() {
    for (let field in this.originalData) {
      this[field] = "";
    }

    this.errors.clear();
  }

  /**
   * Send a POST request to the given URL.
   * .
   * @param {string} url
   */
  post(url) {
    return this.submit("post", url);
  }

  /**
   * Send a PUT request to the given URL.
   * .
   * @param {string} url
   */
  put(url) {
    return this.submit("put", url);
  }

  /**
   * Send a PATCH request to the given URL.
   * .
   * @param {string} url
   */
  patch(url) {
    return this.submit("patch", url);
  }

  /**
   * Send a DELETE request to the given URL.
   * .
   * @param {string} url
   */
  delete(url) {
    return this.submit("delete", url);
  }

  /**
   * Submit the form.
   *
   * @param {string} requestType
   * @param {string} url
   */
  submit(requestType, url) {
    return new Promise((resolve, reject) => {
      axios[requestType](url, this.data())
        .then((response) => {
          this.onSuccess(response.data);

          resolve(response.data);
        })
        .catch((error) => {
          this.onFail(error.response.data.errors);

          reject(error.response.data.errors);
        });
    });
  }

  /**
   * Handle a successful form submission.
   *
   * @param {object} data
   */
  onSuccess(data) {
    this.errors.clear();
  }

  /**
   * Handle a failed form submission.
   *
   * @param {object} errors
   */
  onFail(errors) {
    this.errors.record(errors);
  }


  /**
   * It returns true if any of the values in the object are truthy
   */
  hasData() {
    return Object.values(this.data()).filter(item => item).length > 0;
  }


  /**
   * It returns true if the data object is empty, and false if it is not
   * @returns A boolean value.
   */
  isDefaultDataEmpty() {
    let key = false;

    Object.values(this.data()).forEach(function (val, ind) {
      if (val && val !== 'Add') {
        key = true;
      }
    });

    return key;
  }
}

export default Form;
