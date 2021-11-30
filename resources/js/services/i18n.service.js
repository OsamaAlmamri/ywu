const i18nService = {
  defaultLanguage: "ar",

  languages: [
    {
      lang: "en",
      name: "English",
      flag: "/flags/226-united-states.svg"
    },
    {
      lang: "ar",
      name: "Arabic",
      flag:"/flags/232-yemen.svg"
    }
  ],

  /**
   * Keep the active language in the localStorage
   * @param lang
   */
  setActiveLanguage(lang) {
    localStorage.setItem("lang", lang);
  },

  /**
   * Get the current active language
   * @returns {string | string}
   */
  getActiveLanguage() {
    return localStorage.getItem("lang") || this.defaultLanguage;
  }
};

export default i18nService;
