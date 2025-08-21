import { useEffect, useState } from "react";
import reactLogo from "./assets/react.svg";
import viteLogo from "/vite.svg";
import boy from "./assets/images/boy.webp";
import adult from "./assets/images/adult.jpg";
import "./App.css";
import { supabase } from "./supabase_cliente";

function App() {
  const [count, setCount] = useState(0);
  const [isAdult, setIsAdult] = useState(false);
  const [isLoading, setIsLoading] = useState(true);
  const [data, setData] = useState([]);
  const [TXTfilter, setTXTfilter] = useState("");

  // conocido como hook, engancha el efecto. Si no tiene variable inicializa solo cuando la pagina carga.
  useEffect(() => {
    if (count >= 18) {
      setIsAdult(true);
    }
  }, [count]);

  useEffect(() => {
    const fetchData = async () => {
      setIsLoading(true);
      const { data, error } = await supabase.from("lista_usuarios").select("*");
      if (error) {
        console.error("Error fetching data:", error);
      } else {
        setData(data);
      }
      setIsLoading(false);
    };
    fetchData();
  }, []);

  const handleDelete = async (id) => {
    const { error } = await supabase.from("lista_usuarios").delete().eq("id", id);
    if (error) {
      console.error("Error deleting user:", error);
    } else {
      setData(data.filter((item) => item.id !== id));
    }
  };
  const handleToggleStatus = async (e, item) => {
    const button = e.currentTarget;
    button.classList.add("busy");
    const { error } = await supabase.from("lista_usuarios").update({ estado: !item.estado }).eq("id", item.id);
    if (error) {
      console.error("Error toggling user status:", error);
    } else {
      button.classList.remove("busy");
      setData(data.map((i) => (i.id === item.id ? { ...i, estado: !i.estado } : i)));
    }
  };
  return (
    <>
      <div>
        <a href="https://vite.dev" target="_blank">
          <img src={viteLogo} className="logo" alt="Vite logo" />
        </a>
        <a href="https://react.dev" target="_blank">
          <img src={reactLogo} className="logo react" alt="React logo" />
        </a>
      </div>
      <h1>Vite + React</h1>
      <div className="card">
        <button onClick={() => setCount((count) => count + 1)}>count is {count}</button>
        <p>
          Edit <code>src/App.jsx</code> and save to test HMR
        </p>
      </div>
      <div>
        <img src={isAdult ? adult : boy} className="logo" alt="Vite logo" />
      </div>
      <p className="read-the-docs">Click on the Vite and React logos to learn more</p>
      <div>
        <input type="text" onChange={(e) => setTXTfilter(e.target.value)} />
        {isLoading ? (
          <p>Loading...</p>
        ) : (
          <ul className="list">
            {data
              .filter((item) => item.username.toLowerCase().includes(TXTfilter.toLowerCase()))
              .map((item) => (
                <li key={item.id} onClick={() => console.log(item)}>
                  <button type="button" onClick={(e) => handleToggleStatus(e,item)}>
                    {item.estado ? "Activo" : "Inactivo"}
                  </button>
                  {item.username} - {item.email}
                  <button type="button" className="eliminar" onClick={() => handleDelete(item.id)}>
                    X
                  </button>
                </li>
              ))}
          </ul>
        )}
      </div>
    </>
  );
}

export default App;
