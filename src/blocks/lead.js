// ==========================================================
// Plugins :: zeimoto :: Blocks :: Panel :: Lead
// ==========================================================
//
// Edits lead text inline like the quote block, with the CTA
// label inline and the CTA page chosen in Kirby's page picker.
//
// ==========================================================

import { h, resolveComponent } from "vue"

export default {
  extends: "k-block-type-quote",
  computed: {
    textField() {
      return this.field("text", {})
    },
    ctaLabelField() {
      return this.field("ctaLabel", {})
    },
    ctaPage() {
      return (this.content.cta ?? [])[0] ?? null
    },
  },
  methods: {
    removeCta(event) {
      event?.stopPropagation()
      this.update({ cta: [] })
    },
    pickCta() {
      if (this.disabled) return
      const field = this.field("cta", {})
      this.$panel.dialog.open({
        component: "k-pages-dialog",
        props: {
          endpoint: this.endpoints.field + "/fieldsets/" + (this.fieldset?.type ?? "lead") + "/fields/cta",
          hasSearch: field.search ?? true,
          max: 1,
          multiple: false,
          value: (this.content.cta ?? []).map((page) => page.id),
        },
        onSubmit: (pages) => {
            this.update({ cta: pages.slice(0, 1) })
            this.$panel.dialog.close()
          },
      })
    },
    focus() {
      this.$refs.text?.focus()
    },
  },
  render() {
    const writerInput = resolveComponent("k-writer-input")
    const items = resolveComponent("k-items")
    const empty = resolveComponent("k-empty")
    const textInput = resolveComponent("k-text-input")

    return h(
      "div",
      {
        class: ["k-block-type-lead-editor", { "zeimoto-blocks-lead-fixed": this.textField.toolbar?.inline === false }],
      },
      [
        h(writerInput, {
          ref: "text",
          class: "k-block-type-lead-text",
          disabled: this.disabled,
          inline: this.textField.inline ?? false,
          marks: this.textField.marks,
          nodes: this.textField.nodes,
          toolbar: this.textField.toolbar ?? { inline: true },
          placeholder: this.textField.placeholder ?? "Text …",
          value: this.content.text,
          onInput: (value) => this.update({ text: value }),
        }),
        h("div", { class: "k-block-type-lead-cta" }, [
          h("div", { ref: "cta", class: "k-block-type-lead-cta-page", onClick: () => this.pickCta() }, [
            this.ctaPage
              ? h(items, {
                  items: [
                      {
                        ...this.ctaPage,
                        link: false,
                        buttons: this.disabled
                          ? []
                          : [{ icon: "remove", title: this.$t("remove"), click: (event) => this.removeCta(event) }],
                      },
                    ],
                  layout: "list",
                })
              : h(empty, { icon: "page", layout: "list" }, { default: () => this.$t("field.pages.empty.single") }),
          ]),
          h(textInput, {
            ref: "ctaLabel",
            class: "k-block-type-lead-cta-label",
            disabled: this.disabled,
            placeholder: this.ctaLabelField.placeholder ?? "CTA label …",
            value: this.content.ctaLabel,
            onInput: (value) => this.update({ ctaLabel: value }),
          }),
        ]),
      ]
    )
  },
}
