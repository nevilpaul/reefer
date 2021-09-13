export const converter=(allIn)=>{

  const altcoin = 125.11;
  const converter = allIn/altcoin;
  return Math.round( (converter) *100)/100;

}
