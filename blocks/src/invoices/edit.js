/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from "@wordpress/block-editor";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @param {Object}   props               Properties passed to the function.
 * @param {Object}   props.attributes    Available block attributes.
 * @param {Function} props.setAttributes Function that updates individual attributes.
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
  const blockProps = useBlockProps();

  return (
    <div {...blockProps} className="wp-block-fuellogic-app-invoices">
      <ul>
        <li>
          <i class="fa-solid fa-credit-card"></i>
          <p>Manage Cards</p>
          <i class="fa-solid fa-arrows-up-down"></i>
          <i class="fa-solid fa-filter"></i>
        </li>
        <li>
          <i class="fa-regular fa-circle"></i>
          <div>
            <h3>ABC Supply – Freeport</h3>
            <p>11.25.2024 # FL-1424823</p>
          </div>
          <i class="fa-solid fa-angle-right"></i>
        </li>
        <li>
          <i class="fa-regular fa-circle"></i>
          <div>
            <h3>ABC Supply – Houston</h3>
            <p>11.18.2024 # FL-1424822</p>
          </div>
          <i class="fa-solid fa-angle-right"></i>
        </li>
        <li>
          <i class="fa-regular fa-circle red"></i>
          <div>
            <h3>ABC Supply – Cheyenne</h3>
            <p>11.12.2024 # FL-1424821</p>
          </div>
          <i class="fa-solid fa-angle-right"></i>
        </li>
        <li>
          <i class="fa-regular fa-circle red"></i>
          <div>
            <h3>ABC Supply – Dallas</h3>
            <p>11.07.2024 # FL-1424820</p>
          </div>
          <i class="fa-solid fa-angle-right"></i>
        </li>
        <li class="selected">
          <i class="fa-solid fa-circle-check"></i>
          <div>
            <h3>ABC Supply – Emerald Isle</h3>
            <p>11.01.2024 # FL-1424819</p>
          </div>
          <i class="fa-solid fa-angle-right"></i>
        </li>
        <li>
          <i class="fa-solid fa-circle-check"></i>
          <div>
            <h3>ABC Supply – Benwood</h3>
            <p>10.25.2024 # FL-1424818</p>
          </div>
          <i class="fa-solid fa-angle-right"></i>
        </li>
        <li>
          <i class="fa-solid fa-circle-check"></i>
          <div>
            <h3>ABC Supply – Chico</h3>
            <p>10.21.2024 # FL-1424817</p>
          </div>
          <i class="fa-solid fa-angle-right"></i>
        </li>
        <li>
          <i class="fa-solid fa-circle-check"></i>
          <div>
            <h3>ABC Supply – Houston</h3>
            <p>49 ABC Parkway Beloit, WI 53511…10.18.2024 # FL-1424816</p>
          </div>
          <i class="fa-solid fa-angle-right"></i>
        </li>
        <li>
          <i class="fa-solid fa-circle-check"></i>
          <div>
            <h3>ABC Supply – Freeport</h3>
            <p>10.11.2024 # FL-1424817</p>
          </div>
          <i class="fa-solid fa-angle-right"></i>
        </li>
      </ul>
    </div>
  );
}
