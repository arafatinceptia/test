
from playwright.sync_api import sync_playwright

def verify_frontend():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()

        # Go to the landing page
        page.goto("http://localhost:8000")

        # Verify the product title exists (from seeder)
        try:
            # Check for the featured product name
            page.wait_for_selector("text=Super Immunity Booster", timeout=5000)
            print("Product title found.")

            # Check for variants
            page.wait_for_selector("text=30 Capsules (1 Month Supply)", timeout=5000)
            print("Variant found.")

            # Check for FAQ accordion interactivity
            # Initial state: answer should not be visible (or hidden) - logic depends on Alpine but let's just click it
            faq_button = page.get_by_text("Is this safe for children?")
            faq_button.click()
            # Wait a moment for transition
            page.wait_for_timeout(500)

            # Take a full page screenshot
            page.screenshot(path="verification/landing_page.png", full_page=True)
            print("Screenshot taken at verification/landing_page.png")

        except Exception as e:
            print(f"Verification failed: {e}")
            page.screenshot(path="verification/error.png")
        finally:
            browser.close()

if __name__ == "__main__":
    verify_frontend()
