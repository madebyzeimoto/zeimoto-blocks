// ==========================================================
// Plugins :: zeimoto :: Blocks :: Frontend :: Image
// ==========================================================
//
// Replaces unavailable external images and refreshes their lightbox groups.
//
// ==========================================================

const observedImages = new WeakSet()

export const initializeExternalImages = (onFailure) => {
  document.querySelectorAll("img[data-external-image]").forEach((image) => {
    if (observedImages.has(image)) {
      return
    }

    observedImages.add(image)

    const showFallback = () => {
      if (!image.isConnected) {
        return
      }

      const fallback = image.nextElementSibling
      const link = image.closest(".mds-blocks-image-link")
      const gallery = image.closest(".mds-lightgallery-group")

      image.remove()
      fallback.hidden = false

      if (link?.classList.contains("mds-lightgallery-item")) {
        link.replaceWith(...link.childNodes)
      }

      onFailure?.(gallery)
    }

    image.addEventListener("error", showFallback, { once: true })

    if (image.complete && image.naturalWidth === 0) {
      showFallback()
    }
  })
}
