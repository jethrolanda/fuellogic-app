import { createRoot, useEffect, useState } from "@wordpress/element";
import { OpenStreetMapProvider } from "leaflet-geosearch";

const Results = (props) => {
  const { results, setResults } = props;

  if (!results || results.length === 0) {
    return null;
  }

  const onClick = (e) => {
    console.log(e);
    document.getElementById("site_delivery_address").value = e.target.innerText;
    setResults(null);
  };
  return (
    <ul>
      {results.map((result, index) => {
        return <li onClick={onClick}>{result.label}</li>;
      })}
    </ul>
  );
};

const App = () => {
  const provider = new OpenStreetMapProvider();
  const [address, setAddress] = useState("");
  const [results, setResults] = useState([]);
  const [value, setValue] = useState("");

  useEffect(() => {
    const delayDebounceFn = setTimeout(async () => {
      // setSuggestions([]);

      const results = await provider.search({ query: address });
      console.log(results);
      setResults(results);
      // results.map((res) => {
      //   setSuggestions((values) => [
      //     ...values,
      //     {
      //       coordinates: [res.y, res.x],
      //       location: res.label
      //     }
      //   ]);
      // });
    }, 500);

    return () => clearTimeout(delayDebounceFn);
  }, [address]);

  const onChange = (e) => {
    console.log(e.target.value);
    setAddress(e.target.value);
    // delivery_date
    // document.getElementById("delivery_date").value = date?.format("MM/DD/YYYY");
    // var event = new Event("change");
    // Dispatch it.
    // document.getElementById("site-form").dispatchEvent(event);
  };

  return (
    <>
      <span>
        <input
          type="text"
          id="site_delivery_address"
          name="site_delivery_address"
          placeholder="Search Address"
          onChange={onChange}
        />
        <i class="fa-solid fa-search"></i>
      </span>
      <span className="search-results">
        <Results results={results} setResults={setResults} />
      </span>
    </>
  );
};
createRoot(document.getElementById("search-location")).render(<App />);
