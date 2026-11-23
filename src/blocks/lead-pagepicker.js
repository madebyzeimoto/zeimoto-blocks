// ==========================================================
// Plugins :: zeimoto :: Blocks :: Panel :: Lead Page Picker
// ==========================================================
//
// Uses the native picker and renders its inline CTA row.
//
// ==========================================================

import { h, resolveComponent } from "vue"

export default {
  extends: "k-pagepicker-field",
  render() {
    const collection = resolveComponent("k-collection")
    const button = resolveComponent("k-button")

    return h("div", { class: "k-block-type-lead-cta-page" }, [
      h(
        collection,
        {
          ...this.collection,
          link: !this.disabled,
          items: this.selected.map((item) => ({ ...item, link: this.disabled ? false : this.open })),
          onEmpty: this.disabled ? undefined : this.open,
        },
        this.disabled
          ? {}
          : {
              options: ({ index }) =>
                h(button, { icon: "remove", title: this.$t("remove"), onClick: () => this.remove(index) }),
            }
      ),
    ])
  },
}
