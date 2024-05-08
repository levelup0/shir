const backend = process.env.MIX_BACKEND

export const httpRequestPost = async (url, form) => {
  try {
    const response = await axios.post(`${backend}${url}`, form);
    return response;
  } catch (error) {
      return error; 
  }
};

export const httpRequestGet = async (url, form) => {
  try {
    
    const response = await axios.get(`${backend}${url}`, form);
    return response;
  } catch (error) {
      return error; 
  }
};

export const requestGet = async (url, form) => {
  try {
      const response = fetch(`${backend}${url}`, {
          method: 'GET',
          withCredentials: true,
          crossorigin: true,
          mode: 'no-cors',
          body: form,
      });
      return await response;
  } catch (error) {
      return error;
  }
};