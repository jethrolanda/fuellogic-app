import { store as coreDataStore } from "@wordpress/core-data";
import { useSelect } from "@wordpress/data";

export function usePages(props) {
  const { pages, hasResolved } = useSelect(
    (select) => {
      const selectorArgs = ["postType", "page", { per_page: -1 }];

      return {
        pages: select(coreDataStore).getEntityRecords(...selectorArgs),
        hasResolved: select(coreDataStore).hasFinishedResolution(
          "getEntityRecords",
          selectorArgs
        )
      };
    },
    [props]
  );

  return { pages, hasResolved };
}
