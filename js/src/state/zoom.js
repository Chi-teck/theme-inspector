export default function Zoom() {
  const subscribers = [];

  this.subscribe = sb => subscribers.push(sb);
  const dispatch = () => subscribers.forEach(sb => sb(this.value));

  let steps = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150, 175];
  steps = steps.concat([200, 225, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900]);

  let step = steps.indexOf(100);

  this.in = () => {
    step++;
    dispatch();
  };

  this.out = () => {
    step--;
    dispatch();
  };

  Object.defineProperty(this, 'value', { get: () => steps[step] });
  Object.defineProperty(this, 'isMin', { get: () => step === 0 });
  Object.defineProperty(this, 'isMax', { get: () => step === steps.length - 1 });
}
